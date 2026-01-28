from pydantic import BaseModel, Field, field_validator
from datetime import date, time
from typing import Optional


class JournalBase(BaseModel):
    journal_date: date
    journal_time: time
    day: str
    day_of_year: int
    content: str


class JournalCreate(JournalBase):
    pass


class JournalUpdate(BaseModel):
    journal_time: Optional[time] = None
    day: Optional[str] = None
    day_of_year: Optional[int] = None
    content: Optional[str] = None


class JournalParsed(BaseModel):
    journal_date: date
    journal_time: time
    day: str = Field(min_length=3)
    day_of_year: int = Field(ge=1, le=366)
    content: str

    @field_validator("content")
    @classmethod
    def content_must_not_be_empty(cls, v: str):
        if not v.strip():
            raise ValueError("Journal content cannot be empty")
        return v
