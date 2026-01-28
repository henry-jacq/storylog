# FastAPI and Standard Library
from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
from typing import Dict, Any

# Core Dependencies
from app.core.deps import get_db, get_current_session_id

# Services
from app.services.auth_service import password_manager
from app.services.crypto_service import CryptoService
from app.services.password_derivation import derive_journal_password_from_app_lock
from app.services import settings_service

# Schemas
from app.schemas.common import APIResponse
from app.schemas.settings import (
    SetupRequest,
    ChangePasswordRequest,
    AuthStatusResponse,
    UnlockResponse,
    PasswordChangeResponse
)

router = APIRouter(prefix="/settings", tags=["Settings"])


@router.get("/public", response_model=APIResponse[Dict[str, Any]])
def get_public_settings(db: Session = Depends(get_db)):
    """Get public settings that don't require authentication."""
    return {
        "status": True,
        "data": settings_service.get_public_settings(db),
    }


@router.post("/setup", response_model=APIResponse[Dict[str, Any]])
def setup_application(data: SetupRequest, db: Session = Depends(get_db)):
    """Initialize the application with user settings."""
    try:
        # Perform basic setup
        settings_service.setup(
            db,
            name=data.name,
            email=data.email,
            app_lock_password=data.app_lock_password,
            journal_password=data.journal_password,
        )
        
        # Initialize session with derived journal password if app lock is enabled
        if data.app_lock_password:
            session_data = _initialize_session_after_setup(db, data.app_lock_password)
            return {"status": True, "data": session_data}
        
        return {"status": True, "data": {}}
        
    except ValueError as e:
        raise HTTPException(status_code=400, detail=str(e))


@router.get("/auth-status", response_model=APIResponse[AuthStatusResponse])
def get_authentication_status(
    db: Session = Depends(get_db),
    session_id: str = Depends(get_current_session_id)
):
    """Check authentication status and password requirements."""
    try:
        auth_status = _get_auth_status_data(db, session_id)
        return {"status": True, "data": AuthStatusResponse(**auth_status)}
        
    except Exception as e:
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Failed to get auth status: {str(e)}"
        )


@router.post("/unlock", response_model=APIResponse[UnlockResponse])
def unlock_application(data: Dict[str, str], db: Session = Depends(get_db)):
    """Unlock the application with app lock password."""
    password = data.get("password")
    if not password:
        raise HTTPException(status_code=400, detail="Password is required")
    
    # Verify app lock password
    if not settings_service.unlock(db, password):
        raise HTTPException(status_code=401, detail="Invalid password")
    
    # Get session ID and handle journal encryption
    session_id = get_current_session_id()
    unlock_result = _handle_journal_encryption_after_unlock(db, password, session_id)
    
    response_data = UnlockResponse(
        session_id=session_id,
        encryption_enabled=unlock_result["encryption_enabled"]
    )
    
    return {"status": True, "data": response_data}


@router.put("/change-password", response_model=APIResponse[PasswordChangeResponse])
def change_password(
    data: ChangePasswordRequest,
    db: Session = Depends(get_db)
):
    """Change app lock password and re-encrypt all journals."""
    try:
        from app.services.reencryption_service import update_app_lock_with_reencryption
        
        # Perform password change with re-encryption
        success = update_app_lock_with_reencryption(db, data.old_password, data.new_password)
        
        if not success:
            raise HTTPException(status_code=401, detail="Invalid old password")
        
        # Update session with new derived password
        session_data = _update_session_after_password_change(db, data.new_password)
        
        response_data = PasswordChangeResponse(
            message="Password changed successfully. All journals have been re-encrypted with your new password.",
            session_id=session_data["session_id"],
            journals_reencrypted=True
        )
        
        return {"status": True, "data": response_data}
        
    except Exception as e:
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Failed to change password: {str(e)}"
        )


# Helper functions

def _initialize_session_after_setup(db: Session, app_lock_password: str) -> Dict[str, Any]:
    """Initialize session with derived journal password after setup."""
    session_id = get_current_session_id()
    journal_password = derive_journal_password_from_app_lock(app_lock_password)
    password_manager.store_password(session_id, journal_password, db)
    
    return {"session_id": session_id}


def _get_auth_status_data(db: Session, session_id: str) -> Dict[str, Any]:
    """Get authentication status data."""
    from app.services.settings_service import get, ensure_defaults
    ensure_defaults(db)
    
    app_lock_enabled = bool(get(db, "app_lock_hash"))
    encryption_enabled = get(db, "journal_encryption_enabled") == "true"
    journal_unlocked = password_manager.is_session_valid(session_id)
    
    return {
        "app_lock_enabled": app_lock_enabled,
        "encryption_enabled": encryption_enabled,
        "journal_unlocked": journal_unlocked,
        "needs_journal_password": encryption_enabled and not journal_unlocked,
        "session_id": session_id
    }


def _handle_journal_encryption_after_unlock(db: Session, password: str, session_id: str) -> Dict[str, bool]:
    """Handle journal encryption setup after unlock."""
    from app.services.settings_service import get
    from app.services.password_derivation import derive_journal_password_from_app_lock, verify_derived_journal_password
    
    encryption_enabled = get(db, "journal_encryption_enabled") == "true"
    
    if encryption_enabled:
        # Verify and store derived journal password
        if verify_derived_journal_password(db, password):
            journal_password = derive_journal_password_from_app_lock(password)
            crypto = CryptoService.create_with_password(db, journal_password)
            
            if crypto.enabled:
                password_manager.store_password(session_id, journal_password, db)
        else:
            raise HTTPException(status_code=401, detail="Journal password verification failed")
    
    return {"encryption_enabled": encryption_enabled}


def _update_session_after_password_change(db: Session, new_password: str) -> Dict[str, str]:
    """Update session with new derived journal password after password change."""
    session_id = get_current_session_id()
    
    # Clear old session and store new derived password
    password_manager.clear_session(session_id)
    new_journal_password = derive_journal_password_from_app_lock(new_password)
    password_manager.store_password(session_id, new_journal_password, db)
    
    return {"session_id": session_id}
