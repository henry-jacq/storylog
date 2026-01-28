from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
from app.core.deps import get_db, get_current_session_id
from app.services.auth_service import password_manager
from app.services.crypto_service import CryptoService
from app.schemas.common import APIResponse
from app.schemas.auth import UnlockRequest, UnlockResponse


router = APIRouter(prefix="/auth", tags=["Authentication"])


@router.post("/unlock", response_model=APIResponse[UnlockResponse])
def unlock_journal(
    request: UnlockRequest,
    db: Session = Depends(get_db),
    session_id: str = Depends(get_current_session_id)
):
    """
    Unlock the journal with password and store it in session.
    Returns session ID that should be used for subsequent requests.
    """
    try:
        # Create crypto service to verify password
        crypto = CryptoService.create_with_password(db, request.journal_password)
        
        if not crypto.enabled:
            return {
                "status": True,
                "data": {
                    "success": True,
                    "session_id": session_id,
                    "message": "Journal encryption is disabled"
                }
            }
        
        # Store password in session cache
        if password_manager.store_password(session_id, request.journal_password, db):
            return {
                "status": True,
                "data": {
                    "success": True,
                    "session_id": session_id,
                    "message": "Journal unlocked successfully"
                }
            }
        else:
            raise HTTPException(
                status_code=status.HTTP_401_UNAUTHORIZED,
                detail="Invalid journal password"
            )
            
    except HTTPException:
        raise
    except Exception as e:
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Failed to unlock journal: {str(e)}"
        )


@router.post("/lock", response_model=APIResponse[dict])
def lock_journal(
    session_id: str = Depends(get_current_session_id)
):
    """
    Lock the journal by clearing the password from session.
    """
    try:
        password_manager.clear_session(session_id)
        return {
            "status": True,
            "data": {
                "message": "Journal locked successfully"
            }
        }
    except Exception as e:
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Failed to lock journal: {str(e)}"
        )


@router.get("/status", response_model=APIResponse[dict])
def get_auth_status(
    db: Session = Depends(get_db),
    session_id: str = Depends(get_current_session_id)
):
    """
    Check authentication status and encryption settings.
    """
    try:
        from app.services.settings_service import get, ensure_defaults
        ensure_defaults(db)
        
        encryption_enabled = get(db, "journal_encryption_enabled") == "true"
        is_unlocked = password_manager.is_session_valid(session_id)
        
        return {
            "status": True,
            "data": {
                "encryption_enabled": encryption_enabled,
                "is_unlocked": is_unlocked,
                "session_id": session_id
            }
        }
    except Exception as e:
        raise HTTPException(
            status_code=status.HTTP_500_INTERNAL_SERVER_ERROR,
            detail=f"Failed to get auth status: {str(e)}"
        )
