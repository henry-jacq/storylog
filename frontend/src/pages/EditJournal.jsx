import { useEffect, useRef, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import { JournalsAPI } from "../services/journals";

import Loader from "../components/Loader";
import Toast from "../components/Toast";

export default function EditJournal() {
    const { id } = useParams();
    const navigate = useNavigate();

    const fetchedRef = useRef(false);

    const [journal, setJournal] = useState(null);
    const [content, setContent] = useState("");
    const [saving, setSaving] = useState(false);
    const [loading, setLoading] = useState(true);
    const [toast, setToast] = useState(null);

    /* ---------- Load existing journal (safe) ---------- */
    useEffect(() => {
        if (fetchedRef.current) return;
        fetchedRef.current = true;
        load();
    }, [id]);

    async function load() {
        try {
            const data = await JournalsAPI.get(id);
            setJournal(data);

            // UI works with plain text (no markdown syntax)
            setContent(
                data.content_md
                    .split("\n")
                    .map((l) => l.replace(/^- /, ""))
                    .join("\n")
            );
        } catch {
            setToast({
                type: "error",
                message: "Unable to load journal",
            });
        } finally {
            setLoading(false);
        }
    }

    /* ---------- Save ---------- */
    async function handleSave() {
        if (!content.trim()) return;

        setSaving(true);

        try {
            const payload = {
                content: content
                    .split("\n")
                    .filter(Boolean)
                    .map((l) => `- ${l}`)
                    .join("\n"),
            };

            await JournalsAPI.update(id, payload);

            navigate(`/journals/${id}`, {
                state: {
                    toast: {
                        type: "success",
                        message: "Journal updated",
                    },
                },
            });
        } catch {
            setToast({
                type: "error",
                message: "Failed to save changes",
            });
        } finally {
            setSaving(false);
        }
    }

    /* ---------- UI ---------- */
    if (loading) return <Loader label="Loading journal…" />;
    if (!journal) return null;

    return (
        <>
            <div className="max-w-3xl space-y-8">
                {/* Header */}
                <div>
                    <h1 className="text-2xl font-semibold text-[#1F2933]">
                        Edit Journal
                    </h1>
                    <p className="text-sm text-[#6B7280] mt-1">
                        {journal.journal_date} · {journal.day}
                    </p>
                </div>

                {/* Editor */}
                <textarea
                    value={content}
                    onChange={(e) => setContent(e.target.value)}
                    placeholder="One thought per line…"
                    rows={12}
                    className="
                        w-full rounded-xl border border-[#E5E7EB]
                        bg-white p-4 text-[15px] leading-relaxed
                        focus:outline-none focus:ring-2 focus:ring-[#3B82F6]
                        resize-none
                    "
                />

                {/* Actions */}
                <div className="flex items-center justify-between">
                    <button
                        onClick={() => navigate(-1)}
                        className="text-sm text-[#6B7280] hover:underline"
                        disabled={saving}
                    >
                        Cancel
                    </button>

                    <button
                        onClick={handleSave}
                        disabled={saving || !content.trim()}
                        className={`
                            px-5 py-2 rounded-md text-sm transition
                            ${saving || !content.trim()
                                ? "bg-gray-200 text-gray-400 cursor-not-allowed"
                                : "bg-[#3B82F6] text-white hover:bg-blue-600"}
                        `}
                    >
                        {saving ? "Saving…" : "Save changes"}
                    </button>
                </div>
            </div>

            {toast && <Toast {...toast} />}
        </>
    );
}
