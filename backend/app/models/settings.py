from sqlalchemy import Column, Integer, String, DateTime, Boolean
from sqlalchemy.sql import func
from app.core.database import Base

class Settings(Base):
    __tablename__ = "settings"

    id = Column(Integer, primary_key=True)
    key = Column(String(255), nullable=False, unique=True)
    value = Column(String(2048), nullable=True)

    created_at = Column(DateTime(timezone=True), server_default=func.now())
    updated_at = Column(
        DateTime(timezone=True),
        server_default=func.now(),
        onupdate=func.now(),
    )
