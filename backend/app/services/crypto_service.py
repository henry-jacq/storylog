from typing import Optional
from sqlalchemy.orm import Session
from fastapi import HTTPException, status
from app.services.settings_service import get, ensure_defaults
from app.services.auth_service import password_manager
from app.core.security import (
    derive_journal_key,
    encrypt_text,
    decrypt_text,
    verify_password,
)


class CryptoService:
    """
    Enhanced crypto service with automatic password injection.
    Integrates with password manager for seamless encryption/decryption.
    """
    
    def __init__(self, db: Session, session_id: Optional[str] = None, password: Optional[str] = None):
        self.db = db
        self.session_id = session_id
        self._password = password
        self._key = None
        self._enabled = None
        
        # Initialize encryption settings
        self._initialize()
    
    def _initialize(self):
        """Initialize encryption settings and derive key if needed."""
        ensure_defaults(self.db)
        self._enabled = get(self.db, "journal_encryption_enabled") == "true"
        
        if self._enabled:
            # Try to get password from various sources in priority order
            password = self._get_password()
            
            if not password:
                raise HTTPException(
                    status_code=status.HTTP_401_UNAUTHORIZED,
                    detail="Journal password required. Please unlock the app first."
                )
            
            # Verify password and derive key
            if not self._verify_and_derive_key(password):
                raise HTTPException(
                    status_code=status.HTTP_401_UNAUTHORIZED,
                    detail="Invalid journal password"
                )
    
    def _get_password(self) -> Optional[str]:
        """
        Get password from multiple sources in priority order:
        1. Direct password provided to constructor
        2. Cached password from session
        """
        if self._password:
            return self._password
            
        if self.session_id:
            return password_manager.get_password(self.session_id)
            
        return None
    
    def _verify_and_derive_key(self, password: str) -> bool:
        """Verify password and derive encryption key."""
        try:
            stored_hash = get(self.db, "journal_encryption_hash")
            if not stored_hash:
                return False
                
            if not verify_password(password, stored_hash):
                return False
            
            salt = get(self.db, "journal_encryption_salt")
            if not salt:
                return False
                
            self._key = derive_journal_key(password, salt)
            return True
            
        except Exception:
            return False
    
    @property
    def enabled(self) -> bool:
        """Check if encryption is enabled."""
        return self._enabled
    
    def encrypt(self, text: str) -> str:
        """Encrypt text if encryption is enabled."""
        if not self._enabled:
            return text
        return encrypt_text(self._key, text)
    
    def decrypt(self, text: str) -> str:
        """Decrypt text if encryption is enabled."""
        if not self._enabled:
            return text
        
        # Handle potential non-encrypted content gracefully
        if not text or not isinstance(text, str):
            return text
            
        try:
            return decrypt_text(self._key, text)
        except Exception:
            # If decryption fails, return original text (might be unencrypted)
            return text
    
    def verify_password(self, password: str) -> bool:
        """Verify a password against the stored hash."""
        try:
            stored_hash = get(self.db, "journal_encryption_hash")
            if not stored_hash:
                return False
            return verify_password(password, stored_hash)
        except Exception:
            return False
    
    @classmethod
    def create_with_session(cls, db: Session, session_id: str):
        """Create CryptoService instance with session-based password."""
        return cls(db, session_id=session_id)
    
    @classmethod
    def create_with_password(cls, db: Session, password: str):
        """Create CryptoService instance with direct password."""
        return cls(db, password=password)
