from pydantic import BaseModel
from datetime import date
from typing import Optional


class JournalStatsResponse(BaseModel):
    total_journals: int
    total_words: int
    total_days: int

    current_streak: int
    longest_streak: int

    first_entry: Optional[date]
    last_entry: Optional[date]
