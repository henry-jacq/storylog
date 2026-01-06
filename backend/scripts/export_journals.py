from pathlib import Path
from app.core.database import SessionLocal
from app.models.journal import Journal
from app.services.export_journal import journal_to_markdown
from time import sleep

def run_export(path: str):
    exportDir = Path(path)
    exportDir.mkdir(exist_ok=True)

    db = SessionLocal()

    try:
        journals = (
            db.query(Journal)
            .order_by(Journal.journal_date.asc())
            .all()
        )
        
        for i, journal in enumerate(journals):
            filename = f"{journal.journal_date.isoformat()}.md"
            filepath = exportDir / filename

            md_text = journal_to_markdown(journal)
            filepath.write_text(md_text, encoding="utf-8")
            print(f"[✔] Exporting {i+1}/{len(journals)} files [{filename}]", end="\r")
            sleep(0.01)

    finally:
        print()
        db.close()
