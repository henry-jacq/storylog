from fastapi import APIRouter, UploadFile, File, Depends, HTTPException
from sqlalchemy.orm import Session

from app.core.deps import get_db
from app.models.journal import Journal
from app.services.journal_parser import parse_journal_markdown

router = APIRouter(prefix="/journals", tags=["Journals"])


@router.post("/import")
async def import_journal_md(
    file: UploadFile = File(...),
    db: Session = Depends(get_db),
):
    if not file.filename.endswith(".md"):
        raise HTTPException(status_code=400, detail="Only .md files allowed")

    raw_text = (await file.read()).decode("utf-8")

    # ---- Parse markdown (single source of truth) ----
    try:
        parsed = parse_journal_markdown(raw_text)
    except Exception as e:
        raise HTTPException(status_code=400, detail=str(e))

    # ---- Idempotency check ----
    exists = (
        db.query(Journal)
        .filter(Journal.journal_date == parsed.journal_date)
        .first()
    )

    if exists:
        raise HTTPException(
            status_code=409,
            detail="Journal for this date already exists",
        )

    journal = Journal(
        journal_date=parsed.journal_date,
        journal_time=parsed.journal_time,
        day=parsed.day,
        day_of_year=parsed.day_of_year,
        content_md=parsed.content_md,
        content_html=parsed.content_html,
    )

    db.add(journal)
    db.commit()
    db.refresh(journal)

    return {
        "message": "Journal imported successfully",
        "id": journal.id,
        "date": journal.journal_date,
    }


@router.get("/")
def list_journals(db: Session = Depends(get_db)):
    return (
        db.query(Journal)
        .order_by(Journal.journal_date.desc())
        .all()
    )
