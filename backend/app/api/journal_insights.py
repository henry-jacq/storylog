from fastapi import APIRouter, Depends
from sqlalchemy.orm import Session

from app.core.deps import get_db
from app.schemas.common import APIResponse
from app.schemas.journal_insights import JournalInsightsResponse
from app.services.journal_insights_service import get_journal_insights

router = APIRouter(prefix="/journals/insights", tags=["Journal Insights"])


@router.get("", response_model=APIResponse[JournalInsightsResponse])
def journal_insights(db: Session = Depends(get_db)):
    data = get_journal_insights(db)
    return {
        "status": True,
        "data": data,
    }
