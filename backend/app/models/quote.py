from sqlalchemy import Column, Integer, Text, DateTime, Boolean, JSON
from sqlalchemy.sql import func
from app.core.database import Base


class Quote(Base):
    __tablename__ = "quotes"

    id = Column(Integer, primary_key=True)
    
    text = Column(Text, nullable=False)
    tags = Column(JSON, nullable=True)  # Store tags as JSON array
    
    is_liked = Column(Boolean, default=False, nullable=False)
    is_saved = Column(Boolean, default=False, nullable=False)
    
    created_at = Column(DateTime(timezone=True), server_default=func.now())
    updated_at = Column(DateTime(timezone=True), onupdate=func.now())
