
from pydantic import BaseModel


class UnlockRequest(BaseModel):
    journal_password: str


class UnlockResponse(BaseModel):
    success: bool
    session_id: str
    message: str
