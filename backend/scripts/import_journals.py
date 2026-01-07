import typer
from pathlib import Path
from app.core.database import SessionLocal
from app.services.import_journal import bulk_import_markdown


def run_import(path: str, debug=False):
    DOCS_DIR = Path(path)
    db = SessionLocal()

    try:
        report = bulk_import_markdown(db, DOCS_DIR)

        if report["imported"]:
            print(f"[✔] Imported {len(report['imported'])} Journals.")
            
        if report["skipped"]:
            print(f"[✔] Skipped (already exists): {len(report['skipped'])}")
            if debug:
                for f in report["skipped"]:
                    print(f" - {f}")

        if report["failed"]:
            print(f"[✔] Failed: {len(report['failed'])}")
            if debug:
                for f in report["failed"]:
                    print(f" - {f}")
    finally:
        db.close()
