from pydantic import BaseModel
from typing import Dict, Optional
from datetime import date

from app.schemas.journal import JournalBase


class JournalResponse(JournalBase):
    id: int

    class Config:
        from_attributes = True


class JournalInsightsResponse(BaseModel):
    avg_words_per_entry: float
    most_active_year: Optional[int]
    journals_per_year: Dict[int, int]
    words_per_year: Dict[int, int]
    busiest_weekday: Optional[str]


class JournalStatsResponse(BaseModel):
    total_journals: int
    total_words: int
    total_days: int
    current_streak: int
    longest_streak: int
    first_entry: Optional[date]
    last_entry: Optional[date]
