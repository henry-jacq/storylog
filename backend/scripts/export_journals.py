import typer
import getpass
from pathlib import Path
from app.core.database import SessionLocal
from app.models.journal import Journal
from app.services.journal_transfer import journal_to_markdown
from app.services.crypto_service import CryptoService
from time import sleep

def run_export(path: str):
    exportDir = Path(path)
    exportDir.mkdir(exist_ok=True)

    db = SessionLocal()

    try:
        # Get app lock password and derive journal password for decryption
        try:
            app_lock_password = getpass.getpass("Enter app lock password for export: ")
            if not app_lock_password:
                print("[!] App lock password is required for export")
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
        
        journals = (
            db.query(Journal)
            .order_by(Journal.journal_date.asc())
            .all()
        )
        
        for i, journal in enumerate(journals):
            # Decrypt content before exporting
            try:
                decrypted_content = crypto.decrypt(journal.content)
                # Create a copy of journal with decrypted content for export
                journal_copy = journal
                journal_copy.content = decrypted_content
                
                filename = f"{journal.journal_date.isoformat()}.md"
                filepath = exportDir / filename

                md_text = journal_to_markdown(journal_copy)
                filepath.write_text(md_text, encoding="utf-8")
                print(f"[✔] Exporting {i+1}/{len(journals)} files [{filename}]", end="\r")
                sleep(0.01)
                
            except Exception as e:
                print(f"\n[!] Failed to decrypt journal {journal.id}: {e}")
                continue

    finally:
        print()
        db.close()
