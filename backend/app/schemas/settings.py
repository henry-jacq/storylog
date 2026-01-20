from pydantic import BaseModel, EmailStr
from typing import Optional


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
