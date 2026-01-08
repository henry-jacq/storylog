from sqlalchemy import Column, Integer, Date, Time, String, Text, DateTime
from sqlalchemy.sql import func
from app.core.database import Base


class Journal(Base):
    __tablename__ = "journals"

    id = Column(Integer, primary_key=True)

    journal_date = Column(Date, unique=True, nullable=False)
    journal_time = Column(Time, nullable=False)

    day = Column(String(16), nullable=False)
    day_of_year = Column(Integer, nullable=False)

    content = Column(Text, nullable=False)

    created_at = Column(DateTime(timezone=True), server_default=func.now())
