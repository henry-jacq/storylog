# Standard Library
from sqlalchemy.orm import Session
from typing import Dict, Any, Optional

# Core Security
from app.core.security import hash_password, verify_password, prepare_salt

# Models
from app.models.settings import Settings

# =============================================================================
# Low-level Database Operations
# =============================================================================

def get(db: Session, key: str) -> Optional[str]:
    """Get a setting value from the database."""
    row = db.query(Settings).filter_by(key=key).first()
    return row.value if row else None


def set(db: Session, key: str, value: Optional[str]) -> None:
    """Set a setting value in the database."""
    row = db.query(Settings).filter_by(key=key).first()
    value = value or ""
    
    if not row:
        row = Settings(key=key, value=value)
        db.add(row)
    else:
        row.value = value
    db.commit()


# =============================================================================
# Configuration Constants
# =============================================================================

DEFAULT_KEYS = {
    "is_initialized": "false",
    "name": "",
    "email": "",
    "app_lock_hash": "",
    "journal_encryption_enabled": "true",  # Enabled by default
    "journal_encryption_salt": "",
    "journal_encryption_hash": "",
}


def ensure_defaults(db: Session) -> None:
    """Ensure all default settings exist in the database."""
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


# =============================================================================
# Public API Functions
# =============================================================================

def is_initialized(db: Session) -> bool:
    """Check if the application has been initialized."""
    return get(db, "is_initialized") == "true"


def get_public_settings(db: Session) -> Dict[str, Any]:
    """Get public settings that don't require authentication."""
    ensure_defaults(db)

    return {
        "is_initialized": get(db, "is_initialized") == "true",
        "app_lock_enabled": bool(get(db, "app_lock_hash")),
        "journal_encryption_enabled": get(db, "journal_encryption_enabled") == "true",
        "profile": {
            "name": get(db, "name") or None,
            "email": get(db, "email") or None,
        }
    }


def setup(
    db: Session, 
    *, 
    name: str, 
    email: str, 
    app_lock_password: str, 
    journal_password: Optional[str] = None
) -> None:
    """
    Initialize the application with user settings.
    
    Args:
        db: Database session
        name: User name
        email: User email
        app_lock_password: App lock password
        journal_password: Journal password (deprecated, will be derived)
    
    Raises:
        ValueError: If required fields are missing or invalid
    """
    # Validate mandatory fields
    if not name or not name.strip():
        raise ValueError("Name is required")
    if not email or not email.strip():
        raise ValueError("Email is required")
    if not app_lock_password or not app_lock_password.strip():
        raise ValueError("App lock password is required")
    
    # Validate password length
    if len(app_lock_password.encode("utf-8")) > 72:
        raise ValueError("App lock password too long")

    # Set app lock password
    set(db, "app_lock_hash", hash_password(app_lock_password))

    # Set profile info
    set(db, "name", name.strip())
    set(db, "email", email.strip())
    
    # Auto-derive journal password from app lock password
    from app.services.password_derivation import setup_derived_journal_password
    if setup_derived_journal_password(db, app_lock_password):
        # Journal encryption setup successful
        pass
    else:
        raise ValueError("Failed to setup journal encryption")

    set(db, "is_initialized", "true")


def unlock(db: Session, password: str) -> bool:
    """
    Verify app lock password.
    
    Args:
        db: Database session
        password: Password to verify
        
    Returns:
        True if password is valid, False otherwise
    """
    stored = get(db, "app_lock_hash")
    if not stored:
        return True
    return verify_password(password, stored)
