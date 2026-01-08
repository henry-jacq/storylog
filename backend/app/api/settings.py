from fastapi import APIRouter, Depends
from sqlalchemy.orm import Session

from app.core.deps import get_db
from app.schemas.common import APIResponse
from app.schemas.settings import SettingsResponse, SettingsUpdate
from app.services import settings_service

router = APIRouter(prefix="/settings", tags=["Settings"])


@router.get("", response_model=APIResponse[SettingsResponse])
def get_settings(db: Session = Depends(get_db)):
    settings = settings_service.get_settings(db)
    return {
        "status": True,
        "data": settings,
    }


@router.patch("", response_model=APIResponse[SettingsResponse])
def update_settings(
    data: SettingsUpdate,
    db: Session = Depends(get_db),
):
    settings = settings_service.update_settings(db, data)
    return {
        "status": True,
        "data": settings,
    }
