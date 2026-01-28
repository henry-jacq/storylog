from pydantic import BaseModel, EmailStr
from typing import Optional, Dict, Any


class SettingsResponse(BaseModel):
    is_initialized: bool
    
    # profile
    name: Optional[str]
    email: Optional[EmailStr]
    
    # security
    app_lock_secret: Optional[str] = None
    journal_secret: Optional[str] = None

    class Config:
        from_attributes = True


class SettingsUpdate(BaseModel):
    is_initialized: Optional[bool] = None
    
    # profile
    name: Optional[str]
    email: Optional[EmailStr]
    
    # security
    app_lock_secret: Optional[str] = None
    journal_secret: Optional[str] = None


# Request Models for API Endpoints

class SetupRequest(BaseModel):
    """Request model for setup endpoint."""
    name: Optional[str] = None
    email: Optional[EmailStr] = None
    app_lock_password: Optional[str] = None
    journal_password: Optional[str] = None


class ChangePasswordRequest(BaseModel):
    """Request model for password change endpoint."""
    old_password: str
    new_password: str


class AuthStatusResponse(BaseModel):
    """Response model for authentication status endpoint."""
    app_lock_enabled: bool
    encryption_enabled: bool
    journal_unlocked: bool
    needs_journal_password: bool
    session_id: str


class UnlockResponse(BaseModel):
    """Response model for unlock endpoint."""
    session_id: str
    encryption_enabled: bool


class PasswordChangeResponse(BaseModel):
    """Response model for password change endpoint."""
    message: str
    session_id: str
    journals_reencrypted: bool
