from fastapi import FastAPI
from app.api.v1.journals import router as journal_router

app = FastAPI(title="Storylog")

app.include_router(journal_router)

@app.get("/health")
def health():
    return {"status": "ok"}
