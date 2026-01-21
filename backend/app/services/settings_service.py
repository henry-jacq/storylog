from sqlalchemy.orm import Session
from app.models.settings import Settings
from app.core.security import hash_password, verify_password

# Low-level helpers

def get(db: Session, key: str) -> str | None:
    row = db.query(Settings).filter_by(key=key).first()
    return row.value if row else None


def set(db: Session, key: str, value: str | None):
    row = db.query(Settings).filter_by(key=key).first()
    value = value or ""
    
    if not row:
        row = Settings(key=key, value=value)
        db.add(row)
    else:
        row.value = value
    db.commit()


# Initialization

DEFAULT_KEYS = {
    "is_initialized": "false",
    "name": "",
    "email": "",
    "app_lock_hash": None,
    "journal_key_hash": None,
}


def ensure_defaults(db: Session):
    existing = {
        row.key for row in db.query(Settings.key).all()
    }

    missing = [
        Settings(key=k, value=v)
        for k, v in DEFAULT_KEYS.items()
        if k not in existing
    ]

    if missing:
        db.add_all(missing)
        db.commit()


# Public API

def is_initialized(db: Session) -> bool:
    return get(db, "is_initialized") == "true"


def get_public_settings(db: Session):
    ensure_defaults(db)

    return {
        "is_initialized": get(db, "is_initialized") == "true",
        "app_lock_enabled": bool(get(db, "app_lock_hash")),
        "profile": {
            "name": get(db, "name") or None,
            "email": get(db, "email") or None,
        }
    }


def setup(db: Session, *, name, email, app_lock_password, journal_password):
    if app_lock_password:
        if len(app_lock_password.encode("utf-8")) > 72:
            raise ValueError("App lock password too long")

        set(db, "app_lock_hash", hash_password(app_lock_password))

    if journal_password:
        if len(journal_password.encode("utf-8")) > 72:
            raise ValueError("Journal password too long")

        set(db, "journal_key_hash", hash_password(journal_password))

    if name:
        set(db, "name", name)
    if email:
        set(db, "email", email)

    set(db, "is_initialized", "true")


def unlock(db: Session, password: str) -> bool:
    stored = get(db, "app_lock_hash")
    if not stored:
        return True
    return verify_password(password, stored)
