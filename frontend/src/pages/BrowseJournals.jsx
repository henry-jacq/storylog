import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { JournalsAPI } from "../services/journals";

import Loader from "../components/Loader";
import EmptyState from "../components/EmptyState";
import JournalCard from "../components/JournalCard";
import ConfirmDialog from "../components/ConfirmDialog";
import Toast from "../components/Toast";

export default function BrowseJournals() {
    const navigate = useNavigate();

    const [journals, setJournals] = useState([]);
    const [selected, setSelected] = useState([]);
    const [loading, setLoading] = useState(true);

    const [confirmOpen, setConfirmOpen] = useState(false);
    const [toast, setToast] = useState(null);

    // future-ready
    const [page] = useState(1);

    /* ---------- Data ---------- */

    useEffect(() => {
        loadJournals();
    }, []);

    async function loadJournals() {
        setLoading(true);
        try {
            const data = await JournalsAPI.list();
            setJournals(data);
        } finally {
            setLoading(false);
        }
    }

    async function handleExport() {
        setToast({
            type: "info",
            message: "Export feature coming soon",
        });

        setTimeout(() => setToast(null), 2200);
    }

    /* ---------- Selection ---------- */

    function toggleSelect(id) {
        setSelected((prev) =>
            prev.includes(id)
                ? prev.filter((x) => x !== id)
                : [...prev, id]
        );
    }

    function toggleSelectAll() {
        if (selected.length === journals.length) {
            setSelected([]);
        } else {
            setSelected(journals.map((j) => j.id));
        }
    }

    const hasSelection = selected.length > 0;
    const allSelected =
        journals.length > 0 && selected.length === journals.length;

    /* ---------- Bulk Actions ---------- */

    async function bulkDelete() {
        try {
            for (const id of selected) {
                await JournalsAPI.remove(id);
            }

            setSelected([]);
            await loadJournals();

            setToast({
                type: "success",
                message: `${selected.length} journal(s) deleted`,
            });
        } catch {
            setToast({
                type: "error",
                message: "Failed to delete journals",
            });
        } finally {
            setConfirmOpen(false);
            setTimeout(() => setToast(null), 2500);
        }
    }

    /* ---------- UI States ---------- */

    if (loading) {
        return <Loader label="Loading journals..." />;
    }

    if (journals.length === 0) {
        return (
            <EmptyState
                title="No journals yet"
                description="Your thoughts haven’t been written down yet."
                actionLabel="Write today"
                onAction={() => navigate("/journals/new")}
            />
        );
    }

    /* ---------- Render ---------- */

    return (
        <>
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <h2 className="text-xl font-semibold text-[#1F2933]">
                        Journals
                    </h2>

                    <div className="flex gap-3">
                        {/* Import */}
                        <button
                            disabled={hasSelection}
                            className={`text-sm px-3 py-1.5 rounded-md border transition
                ${hasSelection
                                    ? "text-gray-400 border-gray-200 cursor-not-allowed"
                                    : "text-[#1F2933] border-[#E5E7EB] hover:bg-gray-100"
                                }
              `}
                        >
                            Import
                        </button>

                        {/* Export */}
                        <button
                            disabled={!hasSelection}
                            onClick={handleExport}
                            className={`text-sm px-3 py-1.5 rounded-md border transition
      ${hasSelection
                                    ? "text-[#1F2933] border-[#E5E7EB] hover:bg-gray-100"
                                    : "text-gray-400 border-gray-200 cursor-not-allowed"
                                }
    `}
                        >
                            Export
                        </button>

                        {/* Delete */}
                        <button
                            disabled={!hasSelection}
                            onClick={() => setConfirmOpen(true)}
                            className={`text-sm px-3 py-1.5 rounded-md transition
                ${hasSelection
                                    ? "bg-red-500 text-white hover:bg-red-600"
                                    : "bg-gray-100 text-gray-400 cursor-not-allowed"
                                }
              `}
                        >
                            Delete
                        </button>
                    </div>
                </div>

                {/* Select All */}
                <label className="flex items-center gap-2 text-sm text-[#6B7280]">
                    <input
                        type="checkbox"
                        checked={allSelected}
                        onChange={toggleSelectAll}
                    />
                    Select all
                </label>

                {/* List */}
                <div className="space-y-3">
                    {journals.map((j) => (
                        <JournalCard
                            key={j.id}
                            journal={j}
                            selected={selected.includes(j.id)}
                            onSelect={() => toggleSelect(j.id)}
                            onOpen={() => navigate(`/journals/${j.id}`)}
                        />
                    ))}
                </div>

                {/* Pagination (future-ready) */}
                <div className="pt-6 flex justify-between text-sm text-[#6B7280]">
                    <span>Page {page}</span>
                    <div className="space-x-3">
                        <button className="hover:underline">Previous</button>
                        <button className="hover:underline">Next</button>
                    </div>
                </div>
            </div>

            {/* Confirm Delete */}
            <ConfirmDialog
                open={confirmOpen}
                title="Delete journals?"
                message={`This will permanently delete ${selected.length} journal(s).`}
                confirmText="Delete"
                onCancel={() => setConfirmOpen(false)}
                onConfirm={bulkDelete}
            />

            {/* Toast */}
            {toast && (
                <Toast
                    type={toast.type}
                    message={toast.message}
                />
            )}
        </>
    );
}
