from pathlib import Path
from typing import Dict, List
from sqlalchemy.orm import Session

from app.models.journal import Journal
from app.services.journal_parser import run_parser
from app.services.crypto_service import CryptoService


def bulk_import_markdown(db: Session, docs_dir: Path, crypto: CryptoService
) -> Dict[str, List[str]]:

    report = {
        "imported": [],
        "skipped": [],
        "failed": [],
    }
    
    md_files = sorted(docs_dir.glob("*.md"))

    for md_file in md_files:
        try:
            raw_text = md_file.read_text(encoding="utf-8")

            parsed = run_parser(raw_text)

            # Idempotency check
            exists = (
                db.query(Journal)
                .filter(Journal.journal_date == parsed.journal_date)
                .first()
            )

            if exists:
                report["skipped"].append(md_file.name)
                continue

            journal = Journal(
                journal_date=parsed.journal_date,
                journal_time=parsed.journal_time,
                day=parsed.day,
                day_of_year=parsed.day_of_year,
                content=crypto.encrypt(parsed.content),
            )

            db.add(journal)
            db.commit()

            report["imported"].append(md_file.name)

        except Exception as e:
            db.rollback()
            report["failed"].append(f"{md_file.name} → {e}")

    return report


def journal_to_markdown(journal: Journal) -> str:

    # Header line 1
    date_str = journal.journal_date.isoformat()
    day_str = journal.day
    time_str = journal.journal_time.strftime("%I:%M:%S %p")

    header_1 = f"# {date_str} · {day_str} · {time_str}"

    # Header line 2
    header_2 = f"# Day of year: {journal.day_of_year:03d}"

    # Content
    content = journal.content.strip()

    return "\n".join([header_1,header_2,"",content,""])

