import { useEffect, useState } from "react";
import { useNavigate, useLocation } from "react-router-dom";
import { JournalsAPI } from "../services/journals";

import Loader from "../components/Loader";
import EmptyState from "../components/EmptyState";
import JournalCard from "../components/JournalCard";
import ConfirmDialog from "../components/ConfirmDialog";
import Toast from "../components/Toast";

export default function BrowseJournals() {
    const navigate = useNavigate();
    const location = useLocation();

    /* ---------- State ---------- */
    const [journals, setJournals] = useState([]);
    const [selected, setSelected] = useState([]);
    const [loading, setLoading] = useState(true);

    const [confirmOpen, setConfirmOpen] = useState(false);
    const [toast, setToast] = useState(null);

    const [importing, setImporting] = useState(false);
    const [importProgress, setImportProgress] = useState(null);

    const [lastSelectedId, setLastSelectedId] = useState(null);

    const actionsDisabled = importing;

    // future-ready
    const [page] = useState(1);

    /* ---------- Toast from Navigation ---------- */
    useEffect(() => {
        if (location.state?.toast) {
            setToast(location.state.toast);
            window.history.replaceState({}, "");
            const t = setTimeout(() => setToast(null), 2500);
            return () => clearTimeout(t);
        }
    }, [location.state]);

    /* ---------- Load Data ---------- */
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

    /* ---------- Selection Logic ---------- */
    function handleSelect(id, event) {
        const isMeta = event.metaKey || event.ctrlKey;
        const isShift = event.shiftKey;

        if (!isMeta && !isShift) {
            setSelected((prev) => (prev.includes(id) ? prev : [id]));
            setLastSelectedId(id);
            return;
        }

        if (isMeta) {
            setSelected((prev) =>
                prev.includes(id)
                    ? prev.filter((x) => x !== id)
                    : [...prev, id]
            );
            setLastSelectedId(id);
            return;
        }

        if (isShift && lastSelectedId !== null) {
            const ids = journals.map((j) => j.id);
            const start = ids.indexOf(lastSelectedId);
            const end = ids.indexOf(id);

            if (start === -1 || end === -1) return;

            const range = ids.slice(
                Math.min(start, end),
                Math.max(start, end) + 1
            );

            setSelected((prev) =>
                Array.from(new Set([...prev, ...range]))
            );
        }
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

    /* ---------- Import / Export ---------- */
    async function handleImport(file) {
        setImporting(true);
        setImportProgress("Uploading…");

        try {
            await JournalsAPI.importMd(file);
            setImportProgress("Finalizing…");
            await loadJournals();

            setToast({
                type: "success",
                message: "Journal imported",
            });
        } catch (e) {
            setToast({
                type: "error",
                message: e.message || "Import failed",
            });
        } finally {
            setImporting(false);
            setImportProgress(null);
            setTimeout(() => setToast(null), 2500);
        }
    }

    function handleExport() {
        setToast({
            type: "info",
            message: "Export feature coming soon",
        });

        setTimeout(() => setToast(null), 2200);
    }

    /* ---------- Bulk Delete ---------- */
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
        return <Loader label="Loading journals…" />;
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
                        <label
                            className={`text-sm px-3 py-1.5 rounded-md border transition
                                ${hasSelection || actionsDisabled
                                    ? "text-gray-400 border-gray-200 cursor-not-allowed"
                                    : "text-[#1F2933] border-[#E5E7EB] hover:bg-gray-100 cursor-pointer"
                                }`}
                        >
                            Import
                            <input
                                type="file"
                                accept=".md"
                                disabled={hasSelection || actionsDisabled}
                                className="hidden"
                                onChange={(e) => {
                                    const file = e.target.files?.[0];
                                    if (file) handleImport(file);
                                    e.target.value = "";
                                }}
                            />
                        </label>

                        {/* Export */}
                        <button
                            disabled={!hasSelection || actionsDisabled}
                            onClick={handleExport}
                            className={`text-sm px-3 py-1.5 rounded-md border transition
                                ${hasSelection && !actionsDisabled
                                ? "text-[#1F2933] border-[#E5E7EB] hover:bg-gray-100 hover:cursor-pointer"
                                    : "text-gray-400 border-gray-200 cursor-not-allowed"
                                }`}
                        >
                            Export
                        </button>

                        {/* Delete */}
                        <button
                            disabled={!hasSelection || actionsDisabled}
                            onClick={() => setConfirmOpen(true)}
                            className={`text-sm px-3 py-1.5 rounded-md transition
                                ${hasSelection && !actionsDisabled
                                ? "bg-red-500 text-white hover:bg-red-600 hover:cursor-pointer"
                                    : "bg-gray-100 text-gray-400 cursor-not-allowed"
                                }`}
                        >
                            Delete
                        </button>
                    </div>
                </div>

                {/* Import Progress */}
                {importing && (
                    <div className="text-sm text-[#6B7280] flex items-center gap-3">
                        <div className="h-1 w-24 bg-[#E5E7EB] rounded overflow-hidden">
                            <div className="h-full w-full bg-[#3B82F6] animate-pulse" />
                        </div>
                        <span>{importProgress}</span>
                    </div>
                )}

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
                            onSelect={(e) => handleSelect(j.id, e)}
                            onOpen={() => navigate(`/journals/${j.id}`)}
                        />
                    ))}
                </div>

                {/* Pagination */}
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
            {toast && <Toast type={toast.type} message={toast.message} />}
        </>
    );
}
