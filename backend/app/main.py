from fastapi import FastAPI
from app.api import journals

app = FastAPI(title="Journal System")

app.include_router(journals.router)

@app.get("/health")
def health():
    return {"status": "ok"}
