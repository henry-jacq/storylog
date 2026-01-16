import Toast from "../components/Toast";
import { useState, useEffect } from "react";
import { SettingsAPI } from "../services/settings";

export default function Settings() {
    const [appLock, setAppLock] = useState("");
    const [journalSecret, setJournalSecret] = useState("");
    const [encryptionEnabled, setEncryptionEnabled] = useState(false);
    const [density, setDensity] = useState("comfortable");

    const [toast, setToast] = useState(null);

    useEffect(() => {
        SettingsAPI.get().then(data => {
            setAppLock(data.app_lock_secret || "");
            setJournalSecret(data.journal_secret || "");
        });
    }, []);


    function notify(message, type = "success") {
        setToast({ type, message });
        setTimeout(() => setToast(null), 2200);
    }

    function handleSave() {
        SettingsAPI.update({
            app_lock_secret: appLock || null,
            journal_secret: journalSecret || null,
        });

        notify("Settings saved");
    }

    function handleExportAll() {
        notify("Export all journals — coming soon", "info");
    }

    return (
        <>
            <div className="max-w-2xl space-y-10">
                {/* Header */}
                <div>
                    <h1 className="text-2xl font-semibold text-[#1F2933]">
                        Settings
                    </h1>
                    <p className="mt-1 text-sm text-[#6B7280]">
                        Personal preferences and future options.
                    </p>
                </div>

                {/* App Lock */}
                <section className="space-y-4 rounded-xl border border-[#E5E7EB] bg-white p-6">
                    <div>
                        <h2 className="text-sm font-medium text-[#1F2933]">
                            App Lock
                        </h2>
                        <p className="mt-1 text-sm text-[#6B7280]">
                            Set a password to lock the app on launch.
                        </p>
                    </div>

                    <input
                        type="password"
                        value={appLock}
                        onChange={(e) => setAppLock(e.target.value)}
                        placeholder="Not set"
                        className="w-full rounded-md border border-[#E5E7EB] bg-[#F8F9FA] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#3B82F6]"
                    />

                    <div className="flex justify-end">
                        <button
                            onClick={handleSave}
                            className="rounded-md bg-[#3B82F6] px-4 py-2 text-sm text-white hover:bg-blue-600 transition"
                        >
                            Save
                        </button>
                    </div>
                </section>

                {/* Journal Encryption */}
                <section className="space-y-4 rounded-xl border border-[#E5E7EB] bg-white p-6">
                    <div>
                        <h2 className="text-sm font-medium text-[#1F2933]">
                            Journal Encryption
                        </h2>
                        <p className="mt-1 text-sm text-[#6B7280]">
                            Prepare your journals for future encryption.
                        </p>
                    </div>

                    <input
                        type="password"
                        value={journalSecret}
                        onChange={(e) => setJournalSecret(e.target.value)}
                        placeholder="Encryption secret (optional)"
                        className="w-full rounded-md border border-[#E5E7EB] bg-[#F8F9FA] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#3B82F6]"
                    />

                    <label className="flex items-center gap-3 text-sm text-[#6B7280]">
                        <input
                            type="checkbox"
                            checked={encryptionEnabled}
                            disabled
                        />
                        Enable encryption (coming soon)
                    </label>
                </section>

                {/* Export */}
                <section className="space-y-4 rounded-xl border border-[#E5E7EB] bg-white p-6">
                    <div>
                        <h2 className="text-sm font-medium text-[#1F2933]">
                            Data Export
                        </h2>
                        <p className="mt-1 text-sm text-[#6B7280]">
                            Download all journals as Markdown.
                        </p>
                    </div>

                    <button
                        onClick={handleExportAll}
                        className="rounded-md border border-[#E5E7EB] px-4 py-2 text-sm text-[#1F2933] hover:bg-gray-100 transition"
                    >
                        Export all journals
                    </button>
                </section>

                {/* Appearance */}
                <section className="space-y-4 rounded-xl border border-[#E5E7EB] bg-white p-6">
                    <div>
                        <h2 className="text-sm font-medium text-[#1F2933]">
                            Appearance
                        </h2>
                        <p className="mt-1 text-sm text-[#6B7280]">
                            Reading and writing comfort.
                        </p>
                    </div>

                    <div className="space-y-2 text-sm">
                        <label className="flex items-center gap-3">
                            <input
                                type="radio"
                                name="density"
                                value="comfortable"
                                checked={density === "comfortable"}
                                onChange={() => setDensity("comfortable")}
                            />
                            Comfortable (default)
                        </label>

                        <label className="flex items-center gap-3">
                            <input
                                type="radio"
                                name="density"
                                value="compact"
                                onChange={() => setDensity("compact")}
                                disabled
                            />
                            Compact (coming soon)
                        </label>
                    </div>
                </section>

                {/* Future */}
                <div className="rounded-xl border border-dashed border-[#E5E7EB] p-6 text-sm text-[#6B7280]">
                    More settings will appear here over time.
                </div>
            </div>

            {/* Toast (fixed overlay – no layout shift) */}
            {toast && <Toast {...toast} />}
        </>
    );
}
