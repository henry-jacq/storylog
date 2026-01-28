# FastAPI and Standard Library
from fastapi import APIRouter, UploadFile, File, Depends, HTTPException, Query
from sqlalchemy.orm import Session
from typing import Union

# Core Dependencies
from app.core.deps import get_db, require_crypto_service

# Models
from app.models.journal import Journal

# Services
from app.services.journal_parser import run_parser
from app.services import journal_service
from app.services.crypto_service import CryptoService

# Schemas
from app.schemas.journal import (
    JournalCreate,
    JournalUpdate,
    JournalResponse,
)
from app.schemas.common import APIResponse
from app.schemas.pagination import PaginatedResponse

router = APIRouter(prefix="/journals", tags=["Journals"])


@router.get("", response_model=APIResponse[PaginatedResponse[JournalResponse]],)
def list_journals(
    db: Session = Depends(get_db),
    crypto: CryptoService = Depends(require_crypto_service),
    page: int = Query(1, ge=1),
    limit: int = Query(30, ge=1, le=100),
    year: Union[int, None] = Query(None),
    q: Union[str, None] = Query(None),
):
    data = journal_service.list_journals(
        db,
        page=page,
        limit=limit,
        year=year,
        q=q,
        crypto=crypto
    )

    return {
        "status": True,
        "data": data,
    }


@router.get("/{journal_id}", response_model=APIResponse[JournalResponse])
def get_journal(
    journal_id: int, 
    db: Session = Depends(get_db),
    crypto: CryptoService = Depends(require_crypto_service)
):
    journal = journal_service.get_journal(db, journal_id, crypto)
    return {
        "status": True,
        "data": journal,
    }


@router.post("/", response_model=APIResponse[JournalResponse])
def create_journal(
    data: JournalCreate,
    db: Session = Depends(get_db),
    crypto: CryptoService = Depends(require_crypto_service)
):
    journal = journal_service.create_journal(db, data, crypto)
    return {
        "status": True,
        "data": journal,
    }


@router.patch("/{journal_id}", response_model=APIResponse[JournalResponse])
def update_journal(
    journal_id: int,
    data: JournalUpdate,
    db: Session = Depends(get_db),
    crypto: CryptoService = Depends(require_crypto_service)
):
    journal = journal_service.update_journal(db, journal_id, data, crypto)
    return {
        "status": True,
        "data": journal,
    }


@router.delete("/{journal_id}", response_model=APIResponse[dict])
def delete_journal(
    journal_id: int,
    db: Session = Depends(get_db),
    crypto: CryptoService = Depends(require_crypto_service)
):
    journal_service.delete_journal(db, journal_id, crypto)
    return {
        "status": True,
        "data": {"message": "Journal deleted"},
    }


@router.post("/import", response_model=APIResponse[dict])
async def import_journal_md(
    file: UploadFile = File(...),
    db: Session = Depends(get_db),
    crypto: CryptoService = Depends(require_crypto_service)
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
        content=crypto.encrypt(parsed.content),
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
