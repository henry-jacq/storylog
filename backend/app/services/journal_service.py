from sqlalchemy.orm import Session
from fastapi import HTTPException

from app.models.journal import Journal
from app.schemas.journal import JournalCreate, JournalUpdate
from app.services.journal_parser import markdown_to_safe_html


def list_journals(db: Session):
    return (
        db.query(Journal)
        .order_by(Journal.journal_date.desc())
        .all()
    )


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
        content_md=data.content_md,
        content_html=markdown_to_safe_html(data.content_md),
    )

    db.add(journal)
    db.commit()
    db.refresh(journal)
    return journal


def update_journal(db: Session, journal_id: int, data: JournalUpdate):
    journal = get_journal(db, journal_id)

    for field, value in data.model_dump(exclude_unset=True).items():
        setattr(journal, field, value)

    if data.content_md is not None:
        journal.content_html = markdown_to_safe_html(data.content_md)

    db.commit()
    db.refresh(journal)
    return journal


def delete_journal(db: Session, journal_id: int):
    journal = get_journal(db, journal_id)
    db.delete(journal)
    db.commit()
