# Storylog

Storylog is a quiet, personal journaling application designed to help you **write, reflect and understand your days over time** — without distractions, noise or unnecessary complexity.

It treats journaling not just as writing, but as **personal data that grows with you**.

---

> BREAKING: Journal encryption is now mandatory and automatically derived
> - Users can no longer disable encryption or set separate journal passwords
> - Frontend should remove encryption settings from UI
> - All existing journals will be re-encrypted on first password change

## ✨ What Storylog Is About

* A calm space to write daily journals
* Clear, distraction-free reading and editing
* Your writing stays **portable and future-proof**
* Focus on long-term reflection, not short-term streak chasing
* Designed to evolve into a **personal cognition system**

Storylog values clarity, consistency and insight over productivity pressure.

---

## 📝 Core Features

### Journals

* Create daily journal entries with date, time and context
* Edit and update entries at any time
* Clean reading view for past journals
* Plain-text writing for longevity and portability

### Browse & Organize

* Browse journals in a paginated list
* Select single or multiple journals
* Bulk actions (delete now, export later)
* Keyboard-friendly selection (single, toggle, range)

### Import

* Import journals from Markdown files
* Automatic parsing and validation
* Duplicate detection by date

### Insights & Stats

* Total journals written
* Total words written
* Writing streaks (current & longest)
* Average words per entry
* Most active year and writing patterns
* Year-wise breakdowns of journals and words

These insights are meant to **inform**, not judge.

---

## ⚙️ Settings & Preferences

* App lock (future-ready)
* Journal secret for upcoming encryption features
* Appearance preferences (comfortable now, compact later)
* Export controls (full export coming soon)

Settings are designed to grow gradually, without overwhelming the user.

---

## 🧠 Design Philosophy

* **Minimal UI** – no clutter, no gamification pressure
* **Readable by default** – typography and spacing matter
* **Local-first mindset** – your data is yours
* **Future-aware** – built for long-term use, not trends

Storylog avoids over-engineering while keeping the foundation strong.

---

## 🚀 Getting Started

### Start Frontend

```bash
cd frontend
npm install
npm run dev
```

### Start Backend

```bash
cd backend
python -m venv venv
source venv/bin/activate  # On Windows use `venv\Scripts\activate`
pip install -r requirements.txt
python main.py serve
```

### Start with Docker Compose
```bash
docker-compose up --build
```

---

## 🔮 What’s Coming Next

* Full journal export (single, bulk, filtered)
* Search and advanced filters
* Encryption at rest
* Time-aware insights
* Personal reflection analytics
* **Time-aware RAG** for deep self-reflection
* Journaling as structured personal knowledge

---

## 🧩 Long-Term Vision

Storylog is evolving toward:

* **Journals as data**
* **Self-reflection as signal**
* **Time as context**
* **Memory you can reason with**

A quiet place to think today - a system to understand yourself tomorrow.

