from fastapi import APIRouter

router = APIRouter(prefix="/journals", tags=["Journals"])

@router.get("/")
def list_journals():
    return {"status": "journals endpoint working"}
