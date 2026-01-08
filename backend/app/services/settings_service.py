from sqlalchemy.orm import Session
from app.models.settings import Settings


SETTINGS_ID = 1


def get_settings(db: Session) -> Settings:
    settings = db.get(Settings, SETTINGS_ID)

    if not settings:
        settings = Settings(id=SETTINGS_ID)
        db.add(settings)
        db.commit()
        db.refresh(settings)

    return settings


def update_settings(db: Session, data) -> Settings:
    settings = get_settings(db)

    for field, value in data.model_dump(exclude_unset=True).items():
        setattr(settings, field, value)

    db.commit()
    db.refresh(settings)
    return settings
