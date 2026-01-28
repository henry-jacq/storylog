from fastapi import APIRouter, Depends
from sqlalchemy.orm import Session

from app.core.deps import get_db, get_crypto_service
from app.services.crypto_service import CryptoService
from app.schemas.common import APIResponse
from app.schemas.journal_insights import JournalInsightsResponse
from app.services.journal_insights_service import get_journal_insights

router = APIRouter(prefix="/journals/insights", tags=["Journal Insights"])


@router.get("", response_model=APIResponse[JournalInsightsResponse])
def journal_insights(
    db: Session = Depends(get_db),
    crypto: CryptoService = Depends(get_crypto_service)
):
    data = get_journal_insights(db, crypto)
    return {
        "status": True,
        "data": data,
    }
