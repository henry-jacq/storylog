from fastapi import APIRouter, UploadFile, File, Depends, HTTPException
from sqlalchemy.orm import Session

from app.core.deps import get_db
from app.models.journal import Journal
from app.services.journal_parser import run_parser
from app.services import journal_service
from app.schemas.journal import (
    JournalCreate,
    JournalUpdate,
    JournalResponse,
)
from app.schemas.common import APIResponse

router = APIRouter(prefix="/journals", tags=["Journals"])


@router.get("/", response_model=APIResponse[list[JournalResponse]])
def list_journals(db: Session = Depends(get_db)):
    journals = journal_service.list_journals(db)
    return {
        "status": True,
        "data": journals,
    }


@router.get("/{journal_id}", response_model=APIResponse[JournalResponse])
def get_journal(journal_id: int, db: Session = Depends(get_db)):
    journal = journal_service.get_journal(db, journal_id)
    return {
        "status": True,
        "data": journal,
    }


@router.post("/", response_model=APIResponse[JournalResponse])
def create_journal(
    data: JournalCreate,
    db: Session = Depends(get_db),
):
    journal = journal_service.create_journal(db, data)
    return {
        "status": True,
        "data": journal,
    }


@router.patch("/{journal_id}", response_model=APIResponse[JournalResponse])
def update_journal(
    journal_id: int,
    data: JournalUpdate,
    db: Session = Depends(get_db),
):
    journal = journal_service.update_journal(db, journal_id, data)
    return {
        "status": True,
        "data": journal,
    }


@router.delete("/{journal_id}", response_model=APIResponse[dict])
def delete_journal(
    journal_id: int,
    db: Session = Depends(get_db),
):
    journal_service.delete_journal(db, journal_id)
    return {
        "status": True,
        "data": {"message": "Journal deleted"},
    }


@router.post("/import", response_model=APIResponse[dict])
async def import_journal_md(
    file: UploadFile = File(...),
    db: Session = Depends(get_db),
):
    if not file.filename.endswith(".md"):
        raise HTTPException(status_code=400, detail="Only .md files allowed")

    raw_text = (await file.read()).decode("utf-8")

    try:
        parsed = run_parser(raw_text)
    except Exception as e:
        raise HTTPException(status_code=400, detail=str(e))

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
        "status": True,
        "data": {
            "id": journal.id,
            "date": journal.journal_date,
            "message": "Journal imported successfully",
        },
    }
