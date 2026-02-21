from pydantic import BaseModel, Field
from typing import List, Optional
from datetime import datetime


class QuoteBase(BaseModel):
    text: str = Field(..., min_length=1, max_length=2000)
    tags: Optional[List[str]] = Field(default_factory=list)


class QuoteCreate(QuoteBase):
    is_liked: bool = False
    is_saved: bool = False


class QuoteUpdate(BaseModel):
    text: Optional[str] = Field(None, min_length=1, max_length=2000)
    tags: Optional[List[str]] = None
    is_liked: Optional[bool] = None
    is_saved: Optional[bool] = None


class QuoteResponse(QuoteBase):
    id: int
    is_liked: bool
    is_saved: bool
    created_at: datetime
    updated_at: Optional[datetime] = None

    class Config:
        from_attributes = True


class QuoteStats(BaseModel):
    total_quotes: int
    liked_quotes: int
    saved_quotes: int
