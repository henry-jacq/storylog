from sqlalchemy.orm import Session
from app.models.settings import Settings

def get_settings(db: Session) -> Settings:
    settings = db.query(Settings).filter(Settings.id == 1).first()

    if settings:
        return settings

    settings = Settings(id=1)
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
