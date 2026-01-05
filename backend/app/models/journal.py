from sqlalchemy import Column, Integer, String, Text, Date
from app.core.database import Base

class Journal(Base):
    __tablename__ = "journals"

    id = Column(Integer, primary_key=True)
    date = Column(Date, unique=True, nullable=False)
    raw_markdown = Column(Text, nullable=False)
