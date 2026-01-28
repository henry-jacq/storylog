"""
Password derivation service for deriving journal password from app lock password.

This provides a seamless user experience where users only need to remember
one password (app lock) and the journal password is automatically derived.
"""

import hashlib
import base64
from sqlalchemy.orm import Session
from app.core.security import hash_password, verify_password


def derive_journal_password_from_app_lock(app_lock_password: str, salt: str = "storylog_journal_salt") -> str:
    """
    Derive journal password from app lock password using a secure derivation function.
    
    Args:
        app_lock_password: The user's app lock password
        salt: Fixed salt for journal password derivation
        
    Returns:
        Derived journal password
    """
    # Use PBKDF2 with SHA-256 for secure derivation
    derived = hashlib.pbkdf2_hmac(
        'sha256',
        app_lock_password.encode('utf-8'),
        salt.encode('utf-8'),
        100000,  # 100,000 iterations
        dklen=32  # 32 bytes derived key
    )
    
    # Convert to base64 for a readable password
    return base64.b64encode(derived).decode('utf-8')[:72]  # Limit to 72 chars for bcrypt


def setup_derived_journal_password(db: Session, app_lock_password: str) -> bool:
    """
    Setup journal password derived from app lock password.
    
    Args:
        db: Database session
        app_lock_password: The user's app lock password
        
    Returns:
        True if setup successful, False otherwise
    """
    try:
        from app.services.settings_service import get, set
        from app.core.security import prepare_salt
        
        # Derive journal password
        journal_password = derive_journal_password_from_app_lock(app_lock_password)
        
        # Generate salt for journal encryption
        journal_salt = prepare_salt()
        
        # Store journal encryption settings
        set(db, "journal_encryption_enabled", "true")
        set(db, "journal_encryption_salt", journal_salt)
        set(db, "journal_encryption_hash", hash_password(journal_password))
        
        return True
        
    except Exception:
        return False


def verify_derived_journal_password(db: Session, app_lock_password: str) -> bool:
    """
    Verify that the derived journal password matches the stored hash.
    
    Args:
        db: Database session
        app_lock_password: The user's app lock password
        
    Returns:
        True if verification successful, False otherwise
    """
    try:
        from app.services.settings_service import get
        
        # Get stored journal hash
        stored_hash = get(db, "journal_encryption_hash")
        if not stored_hash:
            return False
        
        # Derive journal password from app lock password
        journal_password = derive_journal_password_from_app_lock(app_lock_password)
        
        # Verify derived password against stored hash
        from app.core.security import verify_password
        return verify_password(journal_password, stored_hash)
        
    except Exception:
        return False
