from pydantic import BaseModel
from typing import Optional


class SettingsResponse(BaseModel):
    app_lock_secret: Optional[str] = None
    journal_secret: Optional[str] = None

    class Config:
        from_attributes = True


class SettingsUpdate(BaseModel):
    app_lock_secret: Optional[str] = None
    journal_secret: Optional[str] = None
