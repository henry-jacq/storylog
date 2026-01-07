import { useEffect, useState } from "react";
import { useNavigate, useParams } from "react-router-dom";
import { JournalsAPI } from "../services/journals";

import Loader from "../components/Loader";
import Toast from "../components/Toast";
import ConfirmDialog from "../components/ConfirmDialog";

export default function ViewJournal() {
    const navigate = useNavigate();
    const { id } = useParams();

    const [journal, setJournal] = useState(null);
    const [loading, setLoading] = useState(true);
    const [toast, setToast] = useState(null);
    const [confirmOpen, setConfirmOpen] = useState(false);

    /* ---------- Load Journal ---------- */
    useEffect(() => {
        load();
    }, [id]);

    async function load() {
        setLoading(true);
        try {
            const data = await JournalsAPI.get(id);
            setJournal(data);
        } catch {
            setToast({
                type: "error",
                message: "Journal not found",
            });
        } finally {
            setLoading(false);
        }
    }

    /* ---------- Actions ---------- */
    async function handleDelete() {
        try {
            await JournalsAPI.remove(id);

            navigate("/journals", {
                state: {
                    toast: {
                        type: "success",
                        message: "Journal deleted",
                    },
                },
            });
        } catch {
            setToast({
                type: "error",
                message: "Failed to delete journal",
            });
            setConfirmOpen(false);
        }
    }

    function handleExport() {
        setToast({
            type: "info",
            message: "Export feature coming soon",
        });

        setTimeout(() => setToast(null), 2200);
    }

    /* ---------- UI States ---------- */
    if (loading) {
        return <Loader label="Loading journal…" />;
    }

    if (!journal) {
        return null;
    }

    /* ---------- Render ---------- */
    return (
        <>
            <div className="space-y-8">
                {/* Header */}
                <div className="flex items-start justify-between">
                    <div>
                        <h1 className="text-2xl font-semibold text-[#1F2933]">
                            {journal.journal_date}
                        </h1>
                        <p className="mt-1 text-sm text-[#6B7280]">
                            {journal.day} · {journal.journal_time} · Day{" "}
                            {journal.day_of_year}
                        </p>
                    </div>

                    <div className="flex gap-3">
                        <button
                            onClick={() => navigate(`/journals/${id}/edit`)}
                            className="text-sm px-3 py-1.5 rounded-md border border-[#E5E7EB] text-[#1F2933] hover:bg-gray-100 hover:cursor-pointer"
                        >
                            Edit
                        </button>

                        <button
                            onClick={handleExport}
                            className="text-sm px-3 py-1.5 rounded-md border border-[#E5E7EB] text-[#1F2933] hover:bg-gray-100 hover:cursor-pointer"
                        >
                            Export
                        </button>

                        <button
                            onClick={() => setConfirmOpen(true)}
                            className="text-sm px-3 py-1.5 rounded-md bg-red-500 text-white hover:bg-red-600 hover:cursor-pointer"
                        >
                            Delete
                        </button>
                    </div>
                </div>

                {/* Content */}
                <div className="bg-white border border-[#E5E7EB] rounded-xl p-6 space-y-4">
                    {journal.content_md
                        .split("\n")
                        .filter(Boolean)
                        .map((line, idx) => (
                            <p
                                key={idx}
                                className="text-[15px] leading-relaxed text-[#1F2933]"
                            >
                                {line.replace(/^- /, "")}
                            </p>
                        ))}
                </div>
            </div>

            {/* Toast */}
            {toast && (
                <Toast
                    type={toast.type}
                    message={toast.message}
                />
            )}

            {/* Confirm Delete */}
            <ConfirmDialog
                open={confirmOpen}
                title="Delete journal?"
                message="This journal will be permanently deleted."
                confirmText="Delete"
                onCancel={() => setConfirmOpen(false)}
                onConfirm={handleDelete}
            />
        </>
    );
}
