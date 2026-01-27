import { useState } from "react";
import { getNowMeta } from "../utils/journalMeta";

function deriveFromDate(dateStr) {
    const d = new Date(dateStr);

    const day = d.toLocaleDateString("en-US", { weekday: "long" });

    const start = new Date(d.getFullYear(), 0, 0);
    const diff =
        d - start +
        (start.getTimezoneOffset() - d.getTimezoneOffset()) * 60 * 1000;

    const dayOfYear = Math.floor(diff / (1000 * 60 * 60 * 24));

    return { day, dayOfYear };
}

export default function JournalForm({ onSubmit, loading = false }) {
    const meta = getNowMeta();
    const derived = deriveFromDate(meta.date);

    const [form, setForm] = useState({
        journal_date: meta.date,
        journal_time: meta.time,
        day: derived.day,
        day_of_year: derived.dayOfYear,
        content: "",
    });

    function updateDate(date) {
        const derived = deriveFromDate(date);
        setForm(f => ({
            ...f,
            journal_date: date,
            day: derived.day,
            day_of_year: derived.dayOfYear,
        }));
    }

    function update(field, value) {
        setForm(f => ({ ...f, [field]: value }));
    }

    function handleSubmit(e) {
        e.preventDefault();
        onSubmit(form);
    }

    return (
        <form onSubmit={handleSubmit} className="space-y-8">
            {/* Metadata */}
            <section className="rounded-xl border border-[#E5E7EB] bg-white p-6 space-y-5">
                {/* Header */}
                <div className="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                    <h3 className="text-sm font-medium text-[#1F2933]">
                        Entry details
                    </h3>

                    {/* Derived info */}
                    <div className="text-xs text-[#6B7280] sm:text-sm">
                        {form.day} · Day {form.day_of_year} of the year
                    </div>
                </div>

                {/* Inputs */}
                <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <Field
                        label="Date"
                        type="date"
                        value={form.journal_date}
                        onChange={updateDate}
                    />

                    <Field
                        label="Time"
                        type="time"
                        step="1"
                        value={form.journal_time}
                        onChange={(v) => update("journal_time", v)}
                    />
                </div>
            </section>

            {/* Content */}
            <section className="rounded-xl border border-[#E5E7EB] bg-white p-6 space-y-3">
                <div>
                    <h3 className="text-sm font-medium text-[#1F2933]">
                        Journal content
                    </h3>
                    <p className="mt-1 text-sm text-[#6B7280]">
                        Write freely. One thought per line.
                    </p>
                </div>

                <textarea
                    value={form.content}
                    onChange={(e) => update("content", e.target.value)}
                    rows={12}
                    placeholder={`Today I felt…
Something interesting happened…
I learned that…`}
                    className="
                        w-full rounded-lg border border-[#E5E7EB]
                        bg-[#F8F9FA] p-4 text-[15px] leading-relaxed
                        focus:outline-none focus:ring-2 focus:ring-[#3B82F6]
                        resize-none transition
                    "
                    required
                />

                <p className="text-xs text-[#94A3B8]">
                    Plain text only. Formatting is handled automatically.
                </p>
            </section>

            {/* Actions */}
            <div className="flex justify-end">
                <button
                    type="submit"
                    disabled={loading}
                    className={`
                        px-5 py-2 rounded-md text-sm transition
                        ${loading
                            ? "bg-gray-200 text-gray-400 cursor-not-allowed"
                            : "bg-[#3B82F6] text-white hover:bg-blue-600 hover:cursor-pointer"
                        }
                    `}
                >
                    {loading ? "Saving…" : "Save journal"}
                </button>
            </div>
        </form>
    );
}

/* Editable field */
function Field({ label, type = "text", value, onChange, step }) {
    return (
        <div className="space-y-1">
            <label className="text-sm text-[#6B7280]">{label}</label>
            <input
                type={type}
                step={step}
                value={value}
                onChange={(e) => onChange(e.target.value)}
                className="w-full rounded-md border border-[#E5E7EB] bg-[#F8F9FA] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#3B82F6] transition"
            />
        </div>
    );
}