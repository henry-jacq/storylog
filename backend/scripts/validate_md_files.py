import re
import typer
from pathlib import Path


def validate_file(md_path: Path) -> bool:
    HEADER_LINE_1 = re.compile(
        r"^# (\d{4}-\d{2}-\d{2}) · ([A-Za-z]+) · (\d{2}:\d{2}:\d{2} (AM|PM))$"
    )
    HEADER_LINE_2 = re.compile(
        r"^# Day of year: (\d{3})$"
    )

    try:
        lines = md_path.read_text(encoding="utf-8").splitlines()
        if len(lines) < 2:
            return False
        if not HEADER_LINE_1.match(lines[0].strip()):
            return False
        if not HEADER_LINE_2.match(lines[1].strip()):
            return False

        for line in lines[2:]:
            stripped = line.strip()
            if not stripped:
                continue
            if not stripped.startswith("- "):
                return False
        return True
    except Exception:
        return False


def run_validation(path: str):
    """Portable validation logic for CLI registration."""
    docs_dir = Path(path)
    
    if not docs_dir.exists():
        typer.secho(f"[✘] Error: Path {path} does not exist.", fg=typer.colors.RED)
        raise typer.Exit(code=1)

    md_files = list(docs_dir.glob("*.md"))
    total = len(md_files)
    invalid_files = [md.name for md in md_files if not validate_file(md)]
    valid_count = total - len(invalid_files)

    typer.echo("\n" + "="*30)
    typer.echo(" Journal Validation Report ")
    typer.echo("="*30)
    typer.echo(f"Total files   : {total}")
    typer.echo(f"Valid files   : {valid_count}")
    
    if invalid_files:
        typer.secho(f"Invalid files : {len(invalid_files)}", fg=typer.colors.RED)
        typer.echo("\n❌ Invalid file list:")
        for f in invalid_files:
            typer.echo(f" - {f}")
    else:
        typer.secho("\n✅ All files are valid.", fg=typer.colors.GREEN, bold=True)
