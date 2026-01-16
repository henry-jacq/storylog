from pydantic import BaseModel
from typing import Dict


class JournalInsightsResponse(BaseModel):
    avg_words_per_entry: float
    most_active_year: int | None

    journals_per_year: Dict[int, int]
    words_per_year: Dict[int, int]

    busiest_weekday: str | None
