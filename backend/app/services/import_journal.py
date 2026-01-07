from pathlib import Path
from sqlalchemy.orm import Session
from typing import Dict, List

from app.models.journal import Journal
from app.services.journal_parser import run_parser


def bulk_import_markdown(
    db: Session,
    docs_dir: Path,
) -> Dict[str, List[str]]:
    """
    Imports all valid markdown journals from a folder.

    Returns a report:
    {
        imported: [...],
        skipped: [...],
        failed: [...]
    }
    """

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

            # ---- Idempotency check ----
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
                content_md=parsed.content_md,
                content_html=parsed.content_html,
            )

            db.add(journal)
            db.commit()

            report["imported"].append(md_file.name)

        except Exception as e:
            db.rollback()
            report["failed"].append(f"{md_file.name} → {e}")

    return report
