import { useState } from "react";
import { getNowMeta } from "../utils/journalMeta";

export default function JournalForm({ onSubmit, loading = false }) {
    const meta = getNowMeta();

    const [form, setForm] = useState({
        journal_date: meta.date,
        journal_time: meta.time,
        day: meta.day,
        day_of_year: meta.dayOfYear,
        content_md: "",
    });

    function update(field, value) {
        setForm((f) => ({ ...f, [field]: value }));
    }

    function handleSubmit(e) {
        e.preventDefault();
        onSubmit(form);
    }

    return (
        <form onSubmit={handleSubmit} className="space-y-6">
            {/* Metadata */}
            <div className="grid grid-cols-2 gap-4">
                <Field
                    label="Date"
                    type="date"
                    value={form.journal_date}
                    onChange={(v) => update("journal_date", v)}
                />

                <Field
                    label="Time"
                    type="time"
                    step="1"
                    value={form.journal_time}
                    onChange={(v) => update("journal_time", v)}
                />

                <Field
                    label="Day"
                    value={form.day}
                    onChange={(v) => update("day", v)}
                />

                <Field
                    label="Day of year"
                    type="number"
                    value={form.day_of_year}
                    onChange={(v) => update("day_of_year", v)}
                />
            </div>

            {/* Content */}
            <div>
                <label className="block mb-2 text-sm text-[#6B7280]">
                    Journal content
                </label>

                <textarea
                    value={form.content_md}
                    onChange={(e) => update("content_md", e.target.value)}
                    rows={10}
                    placeholder="One thought per line. Keep it simple."
                    className="w-full p-4 text-sm leading-relaxed border rounded-lg resize-none focus:outline-none focus:ring-1 focus:ring-[#3B82F6]"
                    required
                />

                <p className="mt-2 text-xs text-[#94A3B8]">
                    Plain text only. Markdown will be generated automatically.
                </p>
            </div>

            {/* Actions */}
            <div className="flex justify-end gap-3">
                <button
                    type="submit"
                    disabled={loading}
                    className={`px-5 py-2 rounded-lg text-white transition
            ${loading
                            ? "bg-gray-300 cursor-not-allowed"
                            : "bg-[#3B82F6] hover:bg-blue-600"
                        }
          `}
                >
                    {loading ? "Saving…" : "Save journal"}
                </button>
            </div>
        </form>
    );
}

/* ---------- Small Field Component ---------- */

function Field({ label, type = "text", value, onChange, step }) {
    return (
        <div>
            <label className="block mb-1 text-sm text-[#6B7280]">{label}</label>
            <input
                type={type}
                step={step}
                value={value}
                onChange={(e) => onChange(e.target.value)}
                className="w-full px-3 py-2 text-sm border rounded-md focus:outline-none focus:ring-1 focus:ring-[#3B82F6]"
            />
        </div>
    );
}
