import re
from pathlib import Path

DOCS_DIR = Path("../../../docs")

HEADER_LINE_1 = re.compile(
    r"^# (\d{4}-\d{2}-\d{2}) · ([A-Za-z]+) · (\d{2}:\d{2}:\d{2} (AM|PM))$"
)

HEADER_LINE_2 = re.compile(
    r"^# Day of year: (\d{3})$"
)


def validate_file(md_path: Path) -> bool:
    try:
        lines = md_path.read_text(encoding="utf-8").splitlines()

        # Must have at least header
        if len(lines) < 2:
            return False

        # Validate headers
        if not HEADER_LINE_1.match(lines[0].strip()):
            return False

        if not HEADER_LINE_2.match(lines[1].strip()):
            return False

        # Validate content lines (Phase 1 extension)
        for line in lines[2:]:
            stripped = line.strip()

            # Allow empty lines
            if not stripped:
                continue

            # Every content line must be a markdown list item
            if not stripped.startswith("- "):
                return False

        return True

    except Exception:
        return False


def main():
    md_files = list(DOCS_DIR.glob("*.md"))

    total = len(md_files)
    valid = 0
    invalid_files = []

    for md in md_files:
        if validate_file(md):
            valid += 1
        else:
            invalid_files.append(md.name)

    print("====== Journal Header + Content Validation Report ======")
    print(f"Total markdown files   : {total}")
    print(f"Eligible (valid) files : {valid}")
    print(f"Invalid files          : {total - valid}")

    if invalid_files:
        print("\n❌ Invalid file list:")
        for f in invalid_files:
            print(f" - {f}")
    else:
        print("\n✅ All files are valid.")


if __name__ == "__main__":
    main()
