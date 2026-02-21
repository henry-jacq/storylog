from fastapi import APIRouter, Depends, HTTPException, Query
from sqlalchemy.orm import Session
from typing import List, Optional

from app.core.deps import get_db
from app.services import quote_service
from app.schemas.quote import QuoteCreate, QuoteUpdate, QuoteResponse, QuoteStats
from app.schemas.common import APIResponse

router = APIRouter(prefix="/quotes", tags=["Quotes"])


@router.get("", response_model=APIResponse[List[QuoteResponse]])
def list_quotes(
    db: Session = Depends(get_db),
    skip: int = Query(0, ge=0),
    limit: int = Query(100, ge=1, le=100),
    search: Optional[str] = Query(None),
    is_liked: Optional[bool] = Query(None),
    is_saved: Optional[bool] = Query(None),
):
    """Get all quotes with optional filtering"""
    quotes = quote_service.get_quotes(
        db=db,
        skip=skip,
        limit=limit,
        search=search,
        is_liked=is_liked,
        is_saved=is_saved
    )
    return {
        "status": True,
        "data": quotes,
    }


@router.get("/stats", response_model=APIResponse[QuoteStats])
def get_quote_stats(db: Session = Depends(get_db)):
    """Get statistics about quotes"""
    stats = quote_service.get_quote_stats(db)
    return {
        "status": True,
        "data": stats,
    }


@router.get("/{quote_id}", response_model=APIResponse[QuoteResponse])
def get_quote(
    quote_id: int,
    db: Session = Depends(get_db)
):
    """Get a single quote by ID"""
    quote = quote_service.get_quote_by_id(db, quote_id)
    if not quote:
        raise HTTPException(status_code=404, detail="Quote not found")
    
    return {
        "status": True,
        "data": quote,
    }


@router.post("", response_model=APIResponse[QuoteResponse])
def create_quote(
    quote: QuoteCreate,
    db: Session = Depends(get_db)
):
    """Create a new quote"""
    db_quote = quote_service.create_quote(db, quote)
    return {
        "status": True,
        "data": db_quote,
    }


@router.patch("/{quote_id}", response_model=APIResponse[QuoteResponse])
def update_quote(
    quote_id: int,
    quote_update: QuoteUpdate,
    db: Session = Depends(get_db)
):
    """Update an existing quote"""
    db_quote = quote_service.update_quote(db, quote_id, quote_update)
    if not db_quote:
        raise HTTPException(status_code=404, detail="Quote not found")
    
    return {
        "status": True,
        "data": db_quote,
    }


@router.delete("/{quote_id}", response_model=APIResponse[dict])
def delete_quote(
    quote_id: int,
    db: Session = Depends(get_db)
):
    """Delete a quote"""
    success = quote_service.delete_quote(db, quote_id)
    if not success:
        raise HTTPException(status_code=404, detail="Quote not found")
    
    return {
        "status": True,
        "data": {"message": "Quote deleted successfully"},
    }


@router.post("/{quote_id}/like", response_model=APIResponse[QuoteResponse])
def toggle_like_quote(
    quote_id: int,
    db: Session = Depends(get_db)
):
    """Toggle the like status of a quote"""
    quote = quote_service.toggle_like_quote(db, quote_id)
    if not quote:
        raise HTTPException(status_code=404, detail="Quote not found")
    
    return {
        "status": True,
        "data": quote,
    }


@router.post("/{quote_id}/save", response_model=APIResponse[QuoteResponse])
def toggle_save_quote(
    quote_id: int,
    db: Session = Depends(get_db)
):
    """Toggle the save status of a quote"""
    quote = quote_service.toggle_save_quote(db, quote_id)
    if not quote:
        raise HTTPException(status_code=404, detail="Quote not found")
    
    return {
        "status": True,
        "data": quote,
    }
