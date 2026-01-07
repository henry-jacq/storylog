import re
from dataclasses import dataclass
from datetime import date, time
from typing import List
import markdown
import html

# ---------- Regex (already validated) ----------

HEADER_LINE_1 = re.compile(
    r"^# (\d{4}-\d{2}-\d{2}) · ([A-Za-z]+) · (\d{2}:\d{2}:\d{2} (AM|PM))$"
)

HEADER_LINE_2 = re.compile(
    r"^# Day of year: (\d{3})$"
)

# ---------- Data Contract ----------

@dataclass
class ParsedJournal:
    journal_date: date
    journal_time: time
    day: str
    day_of_year: int
    content_md: str
    content_html: str


# ---------- Parser ----------

def run_parser(md_text: str) -> ParsedJournal:
    lines = md_text.splitlines()

    if len(lines) < 3:
        raise ValueError("Invalid journal: insufficient lines")

    # ---- Header line 1 ----
    m1 = HEADER_LINE_1.match(lines[0].strip())
    if not m1:
        raise ValueError("Invalid header line 1")

    date_str, day_str, time_str, _ = m1.groups()

    journal_date = date.fromisoformat(date_str)
    journal_time = _parse_time(time_str)

    # ---- Header line 2 ----
    m2 = HEADER_LINE_2.match(lines[1].strip())
    if not m2:
        raise ValueError("Invalid header line 2")

    day_of_year = int(m2.group(1))

    # ---- Content (only list items) ----
    content_lines: List[str] = []

    for line in lines[2:]:
        stripped = line.strip()
        if not stripped:
            continue
        if stripped.startswith("- "):
            content_lines.append(stripped)
        else:
            raise ValueError("Invalid content line detected")

    content_md = "\n".join(content_lines)

    # ---- Markdown → safe HTML ----
    content_html = markdown_to_safe_html(content_md)

    return ParsedJournal(
        journal_date=journal_date,
        journal_time=journal_time,
        day=day_str,
        day_of_year=day_of_year,
        content_md=content_md,
        content_html=content_html,
    )


# ---------- Helpers ----------

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
