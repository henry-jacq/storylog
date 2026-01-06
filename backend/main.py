from fastapi import FastAPI
from app.api.journals import router as journal_router
from app.core.database import Base, engine

app = FastAPI(title="Storylog")

# TEMP: auto-create tables
Base.metadata.create_all(bind=engine)

app.include_router(journal_router)

@app.get("/health")
def health():
    return {"status": "ok"}
