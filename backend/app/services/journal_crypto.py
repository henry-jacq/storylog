from sqlalchemy.orm import Session
from app.services.settings_service import get, ensure_defaults
from app.core.security import (
    derive_journal_key,
    encrypt_text,
    decrypt_text,
    verify_password,
)

class JournalCrypto:
    _cache = {}
     
    def __init__(self, db: Session, password: str | None):
        cache_key = (id(db), password)
        if cache_key in self._cache:
            self.__dict__ = self._cache[cache_key].__dict__
            return
        self.db = db
        self.password = password
        self.enabled = get(db, "journal_encryption_enabled") == "true"
        ensure_defaults(db)

        if self.enabled:
            if not password:
                raise ValueError("Journal password required")

            hash_ = get(db, "journal_encryption_hash")
            salt = get(db, "journal_encryption_salt")

            if not verify_password(password, hash_):
                raise ValueError("Invalid journal password")

            self.key = derive_journal_key(password, salt)
        else:
            self.key = None
        self._cache[cache_key] = self

    def encrypt(self, text: str) -> str:
        if not self.enabled:
            return text
        return encrypt_text(self.key, text)

    def decrypt(self, text: str) -> str:
        if not self.enabled:
            return text
        return decrypt_text(self.key, text)
