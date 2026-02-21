from sqlalchemy.orm import Session
from sqlalchemy import or_
from typing import List, Optional

from app.models.quote import Quote
from app.schemas.quote import QuoteCreate, QuoteUpdate


def get_quotes(
    db: Session,
    skip: int = 0,
    limit: int = 100,
    search: Optional[str] = None,
    is_liked: Optional[bool] = None,
    is_saved: Optional[bool] = None
) -> List[Quote]:
    """Get quotes with optional filtering"""
    query = db.query(Quote)
    
    # Search filter
    if search:
        search_filter = or_(
            Quote.text.ilike(f"%{search}%"),
        )
        # Also search in tags (stored as JSON)
        # For simplicity, we'll convert tags to string and search
        search_filter = or_(search_filter, Quote.tags.astext.ilike(f"%{search}%"))
        query = query.filter(search_filter)
    
    # Liked filter
    if is_liked is not None:
        query = query.filter(Quote.is_liked == is_liked)
    
    # Saved filter
    if is_saved is not None:
        query = query.filter(Quote.is_saved == is_saved)
    
    return query.order_by(Quote.created_at.desc()).offset(skip).limit(limit).all()


def get_quote_by_id(db: Session, quote_id: int) -> Optional[Quote]:
    """Get a single quote by ID"""
    return db.query(Quote).filter(Quote.id == quote_id).first()


def create_quote(db: Session, quote: QuoteCreate) -> Quote:
    """Create a new quote"""
    db_quote = Quote(
        text=quote.text,
        tags=quote.tags,
        is_liked=quote.is_liked,
        is_saved=quote.is_saved
    )
    db.add(db_quote)
    db.commit()
    db.refresh(db_quote)
    return db_quote


def update_quote(db: Session, quote_id: int, quote_update: QuoteUpdate) -> Optional[Quote]:
    """Update an existing quote"""
    db_quote = get_quote_by_id(db, quote_id)
    if not db_quote:
        return None
    
    # Update only provided fields
    update_data = quote_update.model_dump(exclude_unset=True)
    for field, value in update_data.items():
        setattr(db_quote, field, value)
    
    db.commit()
    db.refresh(db_quote)
    return db_quote


def delete_quote(db: Session, quote_id: int) -> bool:
    """Delete a quote"""
    db_quote = get_quote_by_id(db, quote_id)
    if not db_quote:
        return False
    
    db.delete(db_quote)
    db.commit()
    return True


def toggle_like_quote(db: Session, quote_id: int) -> Optional[Quote]:
    """Toggle the is_liked status of a quote"""
    db_quote = get_quote_by_id(db, quote_id)
    if not db_quote:
        return None
    
    db_quote.is_liked = not db_quote.is_liked
    db.commit()
    db.refresh(db_quote)
    return db_quote


def toggle_save_quote(db: Session, quote_id: int) -> Optional[Quote]:
    """Toggle the is_saved status of a quote"""
    db_quote = get_quote_by_id(db, quote_id)
    if not db_quote:
        return None
    
    db_quote.is_saved = not db_quote.is_saved
    db.commit()
    db.refresh(db_quote)
    return db_quote


def get_quote_stats(db: Session) -> dict:
    """Get statistics about quotes"""
    total_quotes = db.query(Quote).count()
    liked_quotes = db.query(Quote).filter(Quote.is_liked == True).count()
    saved_quotes = db.query(Quote).filter(Quote.is_saved == True).count()
    
    return {
        "total_quotes": total_quotes,
        "liked_quotes": liked_quotes,
        "saved_quotes": saved_quotes
    }
