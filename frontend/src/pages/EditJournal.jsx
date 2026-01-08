import { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import { JournalsAPI } from "../services/journals";

import Loader from "../components/Loader";
import Toast from "../components/Toast";

export default function EditJournal() {
    const { id } = useParams();
    const navigate = useNavigate();

    const [journal, setJournal] = useState(null);
    const [content, setContent] = useState("");
    const [saving, setSaving] = useState(false);
    const [loading, setLoading] = useState(true);
    const [toast, setToast] = useState(null);

    /* Load existing journal */
    useEffect(() => {
        load();
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [id]);

    async function load() {
        try {
            setLoading(true);
            const data = await JournalsAPI.get(id);
            setJournal(data);

            // Convert markdown list → plain text (UI format)
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
                content_md: content
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
            <div className="space-y-8">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-semibold text-[#1F2933]">
                            Edit Journal
                        </h1>
                        <p className="mt-1 text-sm text-[#6B7280]">
                            {journal.journal_date} · {journal.day}
                        </p>
                    </div>
                    <button
                        onClick={handleSave}
                        disabled={saving || !content.trim()}
                        className={`
                            text-sm font-normal px-3 py-2 rounded-md transition
                            ${saving || !content.trim()
                                ? "bg-gray-200 text-gray-400 cursor-not-allowed"
                                : "bg-[#3B82F6] text-white hover:bg-blue-600 hover:cursor-pointer"
                            }
                        `}
                    >
                        {saving ? "Saving…" : "Save changes"}
                    </button>
                </div>

                {/* Editor */}
                <textarea
                    value={content}
                    onChange={(e) => setContent(e.target.value)}
                    placeholder="One thought per line…"
                    rows={12}
                    className="
                        w-full rounded-lg border border-[#E5E7EB]
                        bg-white p-4 text-[15px] leading-relaxed
                        focus:outline-none focus:ring-2 focus:ring-[#3B82F6]
                        resize-none mb-4
                    "
                />
            </div>

            {toast && <Toast {...toast} />}
        </>
    );
}
