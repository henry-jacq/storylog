from pathlib import Path
from app.services.journal_parser import parse_journal_markdown

DOCS_DIR = Path("../../../docs")


def main():
    md_files = list(DOCS_DIR.glob("*.md"))

    print("====== Journal Parser Test ======")

    for md in md_files:
        try:
            text = md.read_text(encoding="utf-8")
            parsed = parse_journal_markdown(text)

            print(f"✔ {md.name}")
            print(f"  Date       : {parsed.journal_date}")
            print(f"  Time       : {parsed.journal_time}")
            print(f"  Day        : {parsed.day}")
            print(f"  DayOfYear  : {parsed.day_of_year}")
            print(f"  Items      : {parsed.content_md.count('- ')}")

        except Exception as e:
            print(f"✘ {md.name} → {e}")
            break

    print("\n✅ Parser test completed.")


if __name__ == "__main__":
    main()
