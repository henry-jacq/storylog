from sqlalchemy.orm import Session
from sqlalchemy import func
from datetime import timedelta

from app.models.journal import Journal


def _count_words(text: str) -> int:
    return len(text.split())


def _calculate_streaks(dates: list) -> tuple[int, int]:
    if not dates:
        return 0, 0

    dates = sorted(dates)
    longest = current = 1

    for i in range(1, len(dates)):
        if dates[i] - dates[i - 1] == timedelta(days=1):
            current += 1
            longest = max(longest, current)
        else:
            current = 1

    # current streak = count from last date backwards
    today = dates[-1]
    streak = 1
    for i in range(len(dates) - 2, -1, -1):
        if today - dates[i] == timedelta(days=1):
            streak += 1
            today = dates[i]
        else:
            break

    return streak, longest


def get_journal_stats(db: Session):
    journals = (
        db.query(Journal.journal_date, Journal.content)
        .order_by(Journal.journal_date)
        .all()
    )

    if not journals:
        return {
            "total_journals": 0,
            "total_words": 0,
            "total_days": 0,
            "current_streak": 0,
            "longest_streak": 0,
            "first_entry": None,
            "last_entry": None,
        }

    dates = [j.journal_date for j in journals]
    total_words = sum(_count_words(j.content) for j in journals)

    current_streak, longest_streak = _calculate_streaks(dates)

    return {
        "total_journals": len(journals),
        "total_words": total_words,
        "total_days": len(set(dates)),
        "current_streak": current_streak,
        "longest_streak": longest_streak,
        "first_entry": dates[0],
        "last_entry": dates[-1],
    }
