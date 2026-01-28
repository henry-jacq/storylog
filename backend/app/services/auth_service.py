from typing import Optional
from sqlalchemy.orm import Session
from fastapi import HTTPException, status
from app.services.settings_service import get
from app.core.security import verify_password
import threading
from datetime import datetime, timedelta


class JournalPasswordManager:
    """
    Singleton service for managing journal passwords with session-based caching.
    Automatically resolves passwords from settings when app lock is opened.
    """
    
    _instance = None
    _lock = threading.Lock()
    
    def __new__(cls):
        if cls._instance is None:
            with cls._lock:
                if cls._instance is None:
                    cls._instance = super().__new__(cls)
        return cls._instance
    
    def __init__(self):
        if not hasattr(self, '_initialized'):
            self._password_cache = {}
            self._session_timeout = timedelta(hours=24)  # Session expires after 24 hours
            self._initialized = True
    
    def store_password(self, session_id: str, password: str, db: Session) -> bool:
        """
        Store journal password in session cache after verification.
        Returns True if password is valid and stored, False otherwise.
        """
        try:
            # Verify password against stored hash
            stored_hash = get(db, "journal_encryption_hash")
            if not stored_hash:
                return False
                
            if not verify_password(password, stored_hash):
                return False
            
            # Store in cache with timestamp
            self._password_cache[session_id] = {
                'password': password,
                'created_at': datetime.now()
            }
            return True
            
        except Exception:
            return False
    
    def get_password(self, session_id: str) -> Optional[str]:
        """
        Retrieve journal password from session cache.
        Returns None if not found or expired.
        """
        if session_id not in self._password_cache:
            return None
            
        session_data = self._password_cache[session_id]
        
        # Check if session has expired
        if datetime.now() - session_data['created_at'] > self._session_timeout:
            self.clear_session(session_id)
            return None
            
        return session_data['password']
    
    def clear_session(self, session_id: str):
        """Remove password from cache for given session."""
        self._password_cache.pop(session_id, None)
    
    def clear_all_sessions(self):
        """Clear all cached passwords."""
        self._password_cache.clear()
    
    def is_session_valid(self, session_id: str) -> bool:
        """Check if session exists and is not expired."""
        return self.get_password(session_id) is not None


# Global instance
password_manager = JournalPasswordManager()
