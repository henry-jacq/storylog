"""
Services module for the Storylog application.

This module provides organized access to all business logic services.
Services are organized by domain and follow dependency injection patterns.
"""

from .auth_service import password_manager, JournalPasswordManager
from .crypto_service import CryptoService
from .settings_service import (
    get,
    set,
    ensure_defaults,
    is_initialized,
    get_public_settings,
    setup,
    unlock,
)
from .journal_service import (
    list_journals,
    get_journal,
    create_journal,
    update_journal,
    delete_journal,
)
from .import_journal import bulk_import_markdown
from .journal_crypto import JournalCrypto  # Keep for backward compatibility

__all__ = [
    # Authentication & Password Management
    "password_manager",
    "JournalPasswordManager",
    
    # Encryption Services
    "CryptoService",
    "JournalCrypto",  # Legacy support
    
    # Settings Management
    "get",
    "set", 
    "ensure_defaults",
    "is_initialized",
    "get_public_settings",
    "setup",
    "unlock",
    
    # Journal Operations
    "list_journals",
    "get_journal",
    "create_journal",
    "update_journal",
    "delete_journal",
    
    # Import/Export
    "bulk_import_markdown",
]
