import { useState } from "react";
import { useNavigate } from "react-router-dom";
import JournalForm from "../components/JournalForm";
import Toast from "../components/Toast";
import { JournalsAPI } from "../services/journals";

export default function CreateJournal() {
    const navigate = useNavigate();

    const [saving, setSaving] = useState(false);
    const [toast, setToast] = useState(null);

    async function handleSave(payload) {
        if (saving) return;

        setSaving(true);

        try {
            const journal = await JournalsAPI.create(payload);

            navigate(`/journals/${journal.id}`, {
                state: {
                    toast: {
                        type: "success",
                        message: "Journal created",
                    },
                },
            });
        } catch {
            setToast({
                type: "error",
                message: "Failed to create journal",
            });

            setTimeout(() => setToast(null), 2200);
        } finally {
            setSaving(false);
        }
    }

    return (
        <>
            <div className="max-w-3xl space-y-8">
                {/* Header */}
                <div>
                    <h1 className="text-2xl font-semibold text-[#1F2933]">
                        New Journal
                    </h1>
                    <p className="mt-2 text-sm text-[#6B7280]">
                        Capture today's thoughts before they fade.
                    </p>
                </div>

                {/* Form */}
                <JournalForm
                    onSubmit={handleSave}
                    loading={saving}
                />
            </div>

            {/* Toast */}
            {toast && <Toast {...toast} />}
        </>
    );
}
