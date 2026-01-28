import typer
import getpass
from pathlib import Path
from app.core.database import SessionLocal
from app.services.journal_transfer import bulk_import_markdown
from app.services.crypto_service import CryptoService


def run_import(path: str, debug=False):
    DOCS_DIR = Path(path)
    db = SessionLocal()

    try:
        # Get app lock password and derive journal password
        try:
            app_lock_password = getpass.getpass("Enter app lock password for import: ")
            if not app_lock_password:
                print("[!] App lock password is required for import")
                return
            
            # Derive journal password from app lock password
            from app.services.password_derivation import derive_journal_password_from_app_lock
            journal_password = derive_journal_password_from_app_lock(app_lock_password)
            
            crypto = CryptoService.create_with_password(db, journal_password)
            if not crypto.enabled:
                print("[!] Warning: Journal encryption is not enabled")
                
        except Exception as e:
            print(f"[!] Error: Invalid app lock password - {e}")
            return
        
        report = bulk_import_markdown(db, DOCS_DIR, crypto)

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
