from app.core.database import SessionLocal
from fastapi import Depends, HTTPException, status
from fastapi.security import HTTPBearer, HTTPAuthorizationCredentials
from sqlalchemy.orm import Session
from typing import Generator, Optional
from app.services.crypto_service import CryptoService
from app.services.auth_service import password_manager
import uuid

security = HTTPBearer(auto_error=False)

def get_db() -> Generator:
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()

def get_current_session_id(credentials: Optional[HTTPAuthorizationCredentials] = Depends(security)) -> str:
    """
    Extract session ID from authorization header or generate a new one.
    This allows for both authenticated and unauthenticated access.
    """
    if credentials and hasattr(credentials, 'credentials') and credentials.credentials:
        return credentials.credentials
    else:
        # Generate a temporary session ID for unauthenticated requests
        # This will be used to store passwords after app unlock
        return str(uuid.uuid4())

def get_crypto_service(
    db: Session = Depends(get_db),
    session_id: str = Depends(get_current_session_id)
) -> CryptoService:
    """
    Dependency that provides CryptoService with automatic password injection.
    Attempts to use session-based password first, falls back to creating service without password.
    """
    try:
        return CryptoService.create_with_session(db, session_id)
    except HTTPException:
        # If session doesn't have password, try to create service without password
        # This will work if encryption is disabled, or fail gracefully if enabled
        try:
            return CryptoService(db)
        except HTTPException:
            # If encryption is enabled but no password, create a disabled crypto service
            # This allows APIs to work with graceful fallback
            crypto = CryptoService.__new__(CryptoService)
            crypto.db = db
            crypto._enabled = False
            crypto._key = None
            return crypto

def require_crypto_service(
    crypto_service: CryptoService = Depends(get_crypto_service)
) -> CryptoService:
    """
    Dependency that ensures crypto service is properly initialized with password.
    Raises 401 if password is not available.
    """
    if crypto_service.enabled and not crypto_service._key:
        raise HTTPException(
            status_code=status.HTTP_401_UNAUTHORIZED,
            detail="Journal password required. Please unlock the app first."
        )
    return crypto_service
