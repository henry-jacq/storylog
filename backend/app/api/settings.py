from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.orm import Session
from app.core.deps import get_db
from app.schemas.common import APIResponse
from app.services import settings_service

router = APIRouter(prefix="/settings", tags=["Settings"])


@router.get("/public", response_model=APIResponse[dict])
def get_public(db: Session = Depends(get_db)):
    return {
        "status": True,
        "data": settings_service.get_public_settings(db),
    }


@router.post("/setup")
def setup(data: dict, db: Session = Depends(get_db)):
    try:
        settings_service.setup(
            db,
            name=data.get("name"),
            email=data.get("email"),
            app_lock_password=data.get("app_lock_password"),
            journal_password=data.get("journal_password"),
        )
    except ValueError as e:
        raise HTTPException(status_code=400, detail=str(e))

    return {"status": True}


@router.post("/unlock")
def unlock(data: dict, db: Session = Depends(get_db)):
    if not settings_service.unlock(db, data["password"]):
        raise HTTPException(status_code=401, detail="Invalid password")
    return {"status": True}
