import typer
from fastapi import FastAPI
from app.api.journals import router as journal_router
from app.core.database import Base, engine

from scripts.import_journals import run_import 
from scripts.export_journals import run_export

# 1. FastAPI App Setup
app = FastAPI(title="Storylog")
Base.metadata.create_all(bind=engine)
app.include_router(journal_router)

@app.get("/health")
def health():
    return {"status": "ok"}

# 2. CLI Setup
cli = typer.Typer()

@cli.command()
def serve():
    """Run the FastAPI server (Alternative to fastapi dev)"""
    import uvicorn
    uvicorn.run("main:app", host="127.0.0.1", port=8000, reload=True)

@cli.command()
def import_data(path: str, debug: bool = False):
    typer.secho(f"[✔] Starting Import from {path}...", bold=True)
    run_import(path, debug=debug)
    typer.secho("[✔] Import Finished.", bold=True)

@cli.command()
def export_data(path: str):
    typer.secho(f"[✔] Starting Export to {path}...", bold=True)
    run_export(path)
    typer.secho("[✔] Export Finished.", bold=True)

# 3. Logic to switch between FastAPI and CLI
if __name__ == "__main__":
    cli()
