import re
import html
import markdown
from datetime import date, time

from app.schemas.journal_parsed import JournalParsed


HEADER_LINE_1 = re.compile(
    r"^# (\d{4}-\d{2}-\d{2}) · ([A-Za-z]+) · (\d{2}:\d{2}:\d{2} (AM|PM))$"
)

HEADER_LINE_2 = re.compile(
    r"^# Day of year: (\d{3})$"
)

# Parser

def run_parser(md_text: str) -> JournalParsed:
    lines = md_text.splitlines()

    if len(lines) < 3:
        raise ValueError("Invalid journal: insufficient lines")

    # Header line 1
    m1 = HEADER_LINE_1.match(lines[0].strip())
    if not m1:
        raise ValueError("Invalid header line 1")

    date_str, day_str, time_str, _ = m1.groups()

    journal_date = date.fromisoformat(date_str)
    journal_time = _parse_time(time_str)

    # Header line 2
    m2 = HEADER_LINE_2.match(lines[1].strip())
    if not m2:
        raise ValueError("Invalid header line 2")

    day_of_year = int(m2.group(1))

    # Content (raw markdown, untouched)
    content_md = "\n".join(lines[2:]).strip()

    if not content_md:
        raise ValueError("Journal content is empty")

    # Markdown to HTML
    content_html = markdown.markdown(
        content_md,
        extensions=["extra", "sane_lists"],
        output_format="html5",
    )

    return JournalParsed(
        journal_date=journal_date,
        journal_time=journal_time,
        day=day_str,
        day_of_year=day_of_year,
        content_md=content_md,
        content_html=content_html,
    )


# Helpers

def _parse_time(t: str) -> time:
    """
    Converts '03:38:23 PM' → time(15, 38, 23)
    """
    from datetime import datetime
    return datetime.strptime(t, "%I:%M:%S %p").time()


def markdown_to_safe_html(md_text: str) -> str:
    """
    Converts markdown list to minimal, web-safe HTML.
    """
    raw_html = markdown.markdown(md_text, extensions=["extra"])
    return html.escape(raw_html, quote=False)
