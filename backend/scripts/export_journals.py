from pathlib import Path
from app.core.database import SessionLocal
from app.models.journal import Journal
from backend.app.services.export_journal import journal_to_markdown

EXPORT_DIR = Path("../../../exports")


def main():
    EXPORT_DIR.mkdir(exist_ok=True)

    db = SessionLocal()

    try:
        journals = (
            db.query(Journal)
            .order_by(Journal.journal_date.asc())
            .all()
        )

        print("====== Journal Export Report ======")
        print(f"Total journals: {len(journals)}")

        for journal in journals:
            filename = f"{journal.journal_date.isoformat()}.md"
            filepath = EXPORT_DIR / filename

            md_text = journal_to_markdown(journal)
            filepath.write_text(md_text, encoding="utf-8")

            print(f"✔ Exported {filename}")

        print("\n✅ Export completed.")

    finally:
        db.close()


if __name__ == "__main__":
    main()
