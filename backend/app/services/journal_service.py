from sqlalchemy.orm import Session
from sqlalchemy import extract
from fastapi import HTTPException

from app.models.journal import Journal
from app.schemas.journal import JournalCreate, JournalUpdate
from app.services.journal_parser import markdown_to_text


def list_journals(
    db: Session,
    *,
    page: int,
    limit: int,
    year: int | None = None,
    q: str | None = None,
):
    query = db.query(Journal)

    if year:
        query = query.filter(
            extract("year", Journal.journal_date) == year
        )

    if q:
        query = query.filter(
            Journal.content.ilike(f"%{q}%")
        )

    total = query.count()

    items = (
        query
        .order_by(Journal.journal_date.desc())
        .offset((page - 1) * limit)
        .limit(limit)
        .all()
    )

    return {
        "items": items,
        "page": page,
        "limit": limit,
        "total": total,
    }


def get_journal(db: Session, journal_id: int):
    journal = db.query(Journal).get(journal_id)
    if not journal:
        raise HTTPException(status_code=404, detail="Journal not found")
    return journal


def create_journal(db: Session, data: JournalCreate):
    exists = (
        db.query(Journal)
        .filter(Journal.journal_date == data.journal_date)
        .first()
    )
    if exists:
        raise HTTPException(status_code=409, detail="Journal already exists")

    journal = Journal(
        journal_date=data.journal_date,
        journal_time=data.journal_time,
        day=data.day,
        day_of_year=data.day_of_year,
        content=data.content,
    )

    db.add(journal)
    db.commit()
    db.refresh(journal)
    return journal


def update_journal(db: Session, journal_id: int, data: JournalUpdate):
    journal = get_journal(db, journal_id)

    for field, value in data.model_dump(exclude_unset=True).items():
        setattr(journal, field, value)

    db.commit()
    db.refresh(journal)
    return journal


def delete_journal(db: Session, journal_id: int):
    journal = get_journal(db, journal_id)
    db.delete(journal)
    db.commit()
