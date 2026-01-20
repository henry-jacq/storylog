from sqlalchemy import Column, Integer, String, DateTime, Boolean
from sqlalchemy.sql import func
from app.core.database import Base

class Settings(Base):
    __tablename__ = "settings"

    id = Column(Integer, primary_key=True, default=1)

    # Profile (optional until setup completes)
    name = Column(String(255), nullable=True)
    email = Column(String(255), nullable=True)

    # App-level lock
    app_lock_secret = Column(String(255), nullable=True)

    # Journal encryption
    journal_secret = Column(String(255), nullable=True)

    # Initialization flag
    is_initialized = Column(Boolean, nullable=False, default=False)

    created_at = Column(DateTime(timezone=True), server_default=func.now())
    updated_at = Column(
        DateTime(timezone=True),
        server_default=func.now(),
        onupdate=func.now(),
    )
