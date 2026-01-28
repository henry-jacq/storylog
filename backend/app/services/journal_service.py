# Standard Library
from sqlalchemy.orm import Session
from sqlalchemy import extract
from typing import Dict, Any, Optional

# FastAPI
from fastapi import HTTPException

# Models
from app.models.journal import Journal

# Schemas
from app.schemas.journal import JournalCreate, JournalUpdate

# Services
from app.services.crypto_service import CryptoService


def list_journals(
    db: Session,
    *,
    page: int,
    limit: int,
    year: Optional[int] = None,
    q: Optional[str] = None,
    crypto: CryptoService
) -> Dict[str, Any]:

    query = db.query(Journal)

    if year:
        query = query.filter(
            extract("year", Journal.journal_date) == year
        )

    if q and not crypto.enabled:
        query = query.filter(
            Journal.content.ilike(f"%{q}%")
        )
    elif q and crypto.enabled:
        raise HTTPException(
            status_code=400,
            detail="Search unavailable while journal encryption is enabled"
        )

    total = query.count()

    items = (
        query
        .order_by(Journal.journal_date.desc())
        .offset((page - 1) * limit)
        .limit(limit)
        .all()
    )
    
    for j in items:
        j.content = crypto.decrypt(j.content)

    return {
        "items": items,
        "page": page,
        "limit": limit,
        "total": total,
    }


def get_journal(db: Session, journal_id: int, crypto: CryptoService):
    journal = db.query(Journal).get(journal_id)
    if not journal:
        raise HTTPException(status_code=404, detail="Journal not found")

    crypto = crypto
    journal.content = crypto.decrypt(journal.content)
    
    return journal


def create_journal(db: Session, data: JournalCreate, crypto: CryptoService):
    
    exists = (
        db.query(Journal)
        .filter(Journal.journal_date == data.journal_date)
        .first()
    )
    if exists:
        raise HTTPException(status_code=409, detail="Journal already exists")

    content = "\n".join(
        line.lstrip("- ").strip()
        for line in data.content.splitlines()
        if line.strip()
    )

    journal = Journal(
        journal_date=data.journal_date,
        journal_time=data.journal_time,
        day=data.day,
        day_of_year=data.day_of_year,
        content=crypto.encrypt(content),
    )

    db.add(journal)
    db.commit()
    db.refresh(journal)
    return journal


def update_journal(db: Session, journal_id: int, data: JournalUpdate, crypto: CryptoService):
    journal = db.query(Journal).get(journal_id)

    if data.content is not None:
        journal.content = crypto.encrypt(data.content)

    for field, value in data.model_dump(exclude={"content"}, exclude_unset=True).items():
        setattr(journal, field, value)

    db.commit()
    db.refresh(journal)
    return journal


def delete_journal(db: Session, journal_id: int, crypto: CryptoService):
    journal = get_journal(db, journal_id, crypto)
    db.delete(journal)
    db.commit()
