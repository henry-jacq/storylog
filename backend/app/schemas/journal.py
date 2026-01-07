from pydantic import BaseModel
from datetime import date, time
from typing import Optional


class JournalBase(BaseModel):
    journal_date: date
    journal_time: time
    day: str
    day_of_year: int
    content_md: str


class JournalCreate(JournalBase):
    pass


class JournalUpdate(BaseModel):
    journal_time: Optional[time] = None
    day: Optional[str] = None
    day_of_year: Optional[int] = None
    content_md: Optional[str] = None


class JournalResponse(JournalBase):
    id: int
    content_html: str

    class Config:
        from_attributes = True
