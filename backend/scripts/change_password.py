import getpass
import typer
from app.core.database import SessionLocal
from app.services.reencryption_service import update_app_lock_with_reencryption


def change_password():
    """Change app lock password and re-encrypt all journals"""
    db = SessionLocal()
    
    try:
        typer.secho("[!] Change App Lock Password", bold=True)
        typer.echo("[!] This will re-encrypt all journals with your new password")
        typer.echo("")
        
        # Get current password
        current_password = getpass.getpass("Enter current app lock password: ")
        if not current_password:
            typer.secho("[!] Current password is required", fg=typer.colors.RED)
            return False
        
        # Get new password
        new_password = getpass.getpass("Enter new app lock password: ")
        if not new_password:
            typer.secho("[!] New password is required", fg=typer.colors.RED)
            return False
        
        # Confirm new password
        confirm_password = getpass.getpass("Confirm new app lock password: ")
        if new_password != confirm_password:
            typer.secho("[!] Passwords do not match", fg=typer.colors.RED)
            return False
        
        # Validate password length
        if len(new_password.encode("utf-8")) > 72:
            typer.secho("[!] Password too long (max 72 bytes)", fg=typer.colors.RED)
            return False
        
        typer.echo("")
        
        # Perform password change with re-encryption
        success = update_app_lock_with_reencryption(db, current_password, new_password)
        
        if success:
            typer.secho("[✔] Password changed successfully!", fg=typer.colors.GREEN)
        else:
            typer.secho("[!] Failed to change password. Please check your current password.", fg=typer.colors.RED)
        
        return success
        
    except KeyboardInterrupt:
        typer.echo("\n[!] Password change cancelled")
        return False
    except Exception as e:
        typer.secho(f"[!] Error changing password: {e}", fg=typer.colors.RED)
        return False
    finally:
        db.close()

