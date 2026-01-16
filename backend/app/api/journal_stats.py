from fastapi import APIRouter, Depends
from sqlalchemy.orm import Session

from app.core.deps import get_db
from app.schemas.common import APIResponse
from app.schemas.journal_stats import JournalStatsResponse
from app.services.journal_stats_service import get_journal_stats

router = APIRouter(prefix="/journals/stats", tags=["Journal Stats"])


@router.get("", response_model=APIResponse[JournalStatsResponse])
def journal_stats(db: Session = Depends(get_db)):
    data = get_journal_stats(db)
    return {
        "status": True,
        "data": data,
    }
