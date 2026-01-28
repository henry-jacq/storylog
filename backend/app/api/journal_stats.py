# FastAPI and Standard Library
from fastapi import APIRouter, Depends
from sqlalchemy.orm import Session

# Core Dependencies
from app.core.deps import get_db, get_crypto_service

# Services
from app.services.crypto_service import CryptoService
from app.services.journal_stats_service import get_journal_stats

# Schemas
from app.schemas.common import APIResponse
from app.schemas.journal_response import JournalStatsResponse

router = APIRouter(prefix="/journals/stats", tags=["Journal Stats"])


@router.get("", response_model=APIResponse[JournalStatsResponse])
def journal_stats(
    db: Session = Depends(get_db),
    crypto: CryptoService = Depends(get_crypto_service)
):
    data = get_journal_stats(db, crypto)
    return {
        "status": True,
        "data": data,
    }
