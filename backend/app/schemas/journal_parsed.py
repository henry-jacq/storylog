from pydantic import BaseModel, Field, field_validator
from datetime import date, time


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
