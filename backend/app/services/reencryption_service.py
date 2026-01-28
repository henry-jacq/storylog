"""
Re-encryption service for handling app lock password changes.

When the user changes their app lock password, all journals need to be
re-encrypted with the new derived journal password.
"""

from typing import Tuple, Optional
from sqlalchemy.orm import Session
from app.models.journal import Journal
from app.services.crypto_service import CryptoService
from app.services.password_derivation import (
    derive_journal_password_from_app_lock,
    verify_derived_journal_password
)
from app.services.settings_service import get, set
from app.core.security import hash_password, prepare_salt, derive_journal_key, encrypt_text, decrypt_text


class ReencryptionResult:
    """Result of re-encryption operation."""
    
    def __init__(self, success: bool, reencrypted_count: int = 0, total_count: int = 0, error: Optional[str] = None):
        self.success = success
        self.reencrypted_count = reencrypted_count
        self.total_count = total_count
        self.error = error
    
    @property
    def message(self) -> str:
        if self.error:
            return f"[!] Re-encryption failed: {self.error}"
        return f"[!] Successfully re-encrypted {self.reencrypted_count}/{self.total_count} journals"


def reencrypt_journals_on_password_change(
    db: Session, 
    old_app_lock_password: str, 
    new_app_lock_password: str
) -> bool:
    """
    Re-encrypt all journals when app lock password changes.
    
    Args:
        db: Database session
        old_app_lock_password: Current app lock password
        new_app_lock_password: New app lock password
        
    Returns:
        True if successful, False otherwise
    """
    result = _perform_reencryption(db, old_app_lock_password, new_app_lock_password)
    print(result.message)
    return result.success


def _perform_reencryption(
    db: Session, 
    old_app_lock_password: str, 
    new_app_lock_password: str
) -> ReencryptionResult:
    """Perform the actual re-encryption operation."""
    try:
        # Check if encryption is enabled
        if not _is_encryption_enabled(db):
            return _update_app_lock_only(db, new_app_lock_password)
        
        # Validate old password and prepare keys
        old_key, new_key = _prepare_encryption_keys(db, old_app_lock_password, new_app_lock_password)
        if not old_key or not new_key:
            return ReencryptionResult(False, error="Invalid old password")
        
        # Perform re-encryption
        result = _reencrypt_journal_contents(db, old_key, new_key)
        if not result.success:
            return result
        
        # Update encryption settings
        _update_encryption_settings(db, new_app_lock_password, new_key)
        db.commit()
        
        return result
        
    except Exception as e:
        print(f"Error during re-encryption: {e}")
        db.rollback()
        return ReencryptionResult(False, error=str(e))


def _is_encryption_enabled(db: Session) -> bool:
    """Check if journal encryption is enabled."""
    return get(db, "journal_encryption_enabled") == "true"


def _update_app_lock_only(db: Session, new_app_lock_password: str) -> ReencryptionResult:
    """Update app lock password when encryption is not enabled."""
    set(db, "app_lock_hash", hash_password(new_app_lock_password))
    db.commit()
    return ReencryptionResult(True)


def _prepare_encryption_keys(
    db: Session, 
    old_app_lock_password: str, 
    new_app_lock_password: str
) -> Tuple[Optional[bytes], Optional[bytes]]:
    """Prepare encryption keys for re-encryption."""
    # Verify old password
    if not verify_derived_journal_password(db, old_app_lock_password):
        print("Old app lock password verification failed")
        return None, None
    
    # Derive journal passwords
    old_journal_password = derive_journal_password_from_app_lock(old_app_lock_password)
    new_journal_password = derive_journal_password_from_app_lock(new_app_lock_password)
    
    # Get and update salt
    old_salt = get(db, "journal_encryption_salt")
    new_salt = prepare_salt()
    set(db, "journal_encryption_salt", new_salt)
    
    # Derive keys
    old_key = derive_journal_key(old_journal_password, old_salt)
    new_key = derive_journal_key(new_journal_password, new_salt)
    
    return old_key, new_key


def _reencrypt_journal_contents(
    db: Session, 
    old_key: bytes, 
    new_key: bytes
) -> ReencryptionResult:
    """Re-encrypt all journal contents."""
    journals = db.query(Journal).all()
    print(f"[!] Re-encrypting {len(journals)} journals...")
    
    reencrypted_count = 0
    
    for journal in journals:
        if _reencrypt_single_journal(journal, old_key, new_key):
            reencrypted_count += 1
        
        # Update progress
        print(f"[!] Progress: {reencrypted_count}/{len(journals)} journals re-encrypted", end="\r")
    
    # Clear progress line
    print()
    
    return ReencryptionResult(True, reencrypted_count, len(journals))


def _reencrypt_single_journal(journal: Journal, old_key: bytes, new_key: bytes) -> bool:
    """Re-encrypt a single journal content."""
    try:
        # Try to decrypt with old key first
        try:
            decrypted_content = decrypt_text(old_key, journal.content)
            journal.content = encrypt_text(new_key, decrypted_content)
        except Exception:
            # If decryption fails, treat as unencrypted and encrypt with new key
            journal.content = encrypt_text(new_key, journal.content)
        
        return True
        
    except Exception as e:
        print(f"\nFailed to process journal {journal.id}: {e}")
        return False


def _update_encryption_settings(db: Session, new_app_lock_password: str, new_key: bytes) -> None:
    """Update encryption settings after successful re-encryption."""
    # Update journal encryption settings
    new_journal_password = derive_journal_password_from_app_lock(new_app_lock_password)
    set(db, "journal_encryption_hash", hash_password(new_journal_password))
    
    # Update app lock hash
    set(db, "app_lock_hash", hash_password(new_app_lock_password))


def update_app_lock_with_reencryption(
    db: Session,
    old_password: str,
    new_password: str
) -> bool:
    """
    Update app lock password and re-encrypt journals.
    
    Args:
        db: Database session
        old_password: Current app lock password
        new_password: New app lock password
        
    Returns:
        True if successful, False otherwise
    """
    # Verify old password
    from app.services.settings_service import verify_password
    stored_hash = get(db, "app_lock_hash")
    if not verify_password(old_password, stored_hash):
        return False
    
    # Perform re-encryption
    return reencrypt_journals_on_password_change(db, old_password, new_password)
