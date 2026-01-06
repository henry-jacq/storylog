from pathlib import Path
from app.core.database import SessionLocal
from backend.app.services.import_journal import bulk_import_markdown_folder

DOCS_DIR = Path("../../../docs")


def main():
    db = SessionLocal()

    try:
        report = bulk_import_markdown_folder(db, DOCS_DIR)

        print("====== Bulk Journal Import Report ======")
        print(f"Imported : {len(report['imported'])}")
        print(f"Skipped  : {len(report['skipped'])}")
        print(f"Failed   : {len(report['failed'])}")

        if report["imported"]:
            print("\n✅ Imported:")
            for f in report["imported"]:
                print(f" - {f}")

        if report["skipped"]:
            print("\n⚠️ Skipped (already exists):")
            for f in report["skipped"]:
                print(f" - {f}")

        if report["failed"]:
            print("\n❌ Failed:")
            for f in report["failed"]:
                print(f" - {f}")

    finally:
        db.close()


if __name__ == "__main__":
    main()
