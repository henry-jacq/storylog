from app.models.journal import Journal

def journal_to_markdown(journal: Journal) -> str:
    """
    Converts a Journal DB row back into canonical markdown.
    """

    # Header line 1
    date_str = journal.journal_date.isoformat()
    day_str = journal.day
    time_str = journal.journal_time.strftime("%I:%M:%S %p")

    header_1 = f"# {date_str} · {day_str} · {time_str}"

    # Header line 2
    header_2 = f"# Day of year: {journal.day_of_year:03d}"

    # Content
    content = journal.content_md.strip()

    return "\n".join([header_1,header_2,"",content,""])
