import typer
from pathlib import Path
from app.services.journal_parser import run_parser

def run_parser_test(path: str, limit: int = None):
    """
    Tests the journal parser against markdown files in a directory.
    - limit: Optional integer to test only the first N files.
    """
    docs_dir = Path(path)
    
    if not docs_dir.exists():
        typer.secho(f"[✘] Path not found: {path}", fg=typer.colors.RED)
        return

    md_files = list(docs_dir.glob("*.md"))
    if limit:
        md_files = md_files[:limit]

    typer.secho(f"====== Journal Parser Test ({len(md_files)} files) ======", bold=True)

    for md in md_files:
        try:
            text = md.read_text(encoding="utf-8")
            parsed = run_parser(text)

            # Use green checkmark for success
            success_msg = typer.style(f"✔ {md.name}", fg=typer.colors.GREEN)
            typer.echo(success_msg)
            
            typer.echo(f"  Date       : {parsed.journal_date}")
            typer.echo(f"  Time       : {parsed.journal_time}")
            typer.echo(f"  Day        : {parsed.day}")
            typer.echo(f"  DayOfYear  : {parsed.day_of_year}")
            typer.echo(f"  Items      : {parsed.content.count('- ')}")

        except Exception as e:
            typer.secho(f"✘ {md.name} → {e}", fg=typer.colors.RED)
            # We don't necessarily want to 'break' on a single file error 
            # in a test tool, but you can if preferred.
            continue

    typer.secho("\n[✔] Parser test completed.", fg=typer.colors.GREEN, bold=True)
