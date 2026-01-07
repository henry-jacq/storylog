from pydantic import BaseModel
from typing import Generic, TypeVar, Optional

T = TypeVar("T")


class APIResponse(BaseModel, Generic[T]):
    status: bool
    data: Optional[T] = None
