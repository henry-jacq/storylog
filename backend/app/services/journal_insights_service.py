from sqlalchemy.orm import Session
from sqlalchemy import extract, func

from app.models.journal import Journal


def get_journal_insights(db: Session):
    journals = db.query(Journal).all()

    if not journals:
        return {
            "avg_words_per_entry": 0,
            "most_active_year": None,
            "journals_per_year": {},
            "words_per_year": {},
            "busiest_weekday": None,
        }

    journals_per_year = {}
    words_per_year = {}
    weekday_count = {}

    total_words = 0

    for j in journals:
        year = j.journal_date.year
        weekday = j.journal_date.strftime("%A")
        words = len(j.content.split())

        journals_per_year[year] = journals_per_year.get(year, 0) + 1
        words_per_year[year] = words_per_year.get(year, 0) + words

        weekday_count[weekday] = weekday_count.get(weekday, 0) + 1
        total_words += words

    most_active_year = max(journals_per_year, key=journals_per_year.get)
    busiest_weekday = max(weekday_count, key=weekday_count.get)

    return {
        "avg_words_per_entry": round(total_words / len(journals), 2),
        "most_active_year": most_active_year,
        "journals_per_year": journals_per_year,
        "words_per_year": words_per_year,
        "busiest_weekday": busiest_weekday,
    }
