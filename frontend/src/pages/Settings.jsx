import { useEffect, useState } from "react";
import Toast from "../components/Toast";
import { SettingsAPI } from "../services/settings";

export default function Settings() {
    // profile (public)
    const [profile, setProfile] = useState(null);

    // write-only inputs
    const [newAppLock, setNewAppLock] = useState("");
    const [newJournalSecret, setNewJournalSecret] = useState("");

    // ui-only
    const [density, setDensity] = useState("comfortable");
    const [toast, setToast] = useState(null);

    useEffect(() => {
        SettingsAPI.getPublic().then(setProfile);
    }, []);

    function notify(message, type = "success") {
        setToast({ type, message });
        setTimeout(() => setToast(null), 2200);
    }

    async function handleSaveSecurity() {
        if (!newAppLock && !newJournalSecret) {
            notify("Nothing to update", "info");
            return;
        }

        await SettingsAPI.finishSetup({
            app_lock_password: newAppLock || null,
            journal_password: newJournalSecret || null,
        });

        setNewAppLock("");
        setNewJournalSecret("");

        notify("Security settings updated");
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

                {/* Profile (READ ONLY) */}
                <section className="space-y-2 rounded-xl border border-[#E5E7EB] bg-white p-6">
                    <h2 className="text-sm font-medium text-[#1F2933]">
                        Profile
                    </h2>

                    <p className="text-sm text-[#6B7280]">
                        {profile?.profile?.name || "Anonymous"}
                    </p>

                    {profile?.profile?.email && (
                        <p className="text-sm text-[#6B7280]">
                            {profile.profile.email}
                        </p>
                    )}
                </section>

                {/* App Lock */}
                <section className="space-y-4 rounded-xl border border-[#E5E7EB] bg-white p-6">
                    <div>
                        <h2 className="text-sm font-medium text-[#1F2933]">
                            App Lock
                        </h2>
                        <p className="mt-1 text-sm text-[#6B7280]">
                            {profile?.app_lock_enabled
                                ? "App lock is enabled"
                                : "No app lock set"}
                        </p>
                    </div>

                    <input
                        type="password"
                        value={newAppLock}
                        onChange={(e) => setNewAppLock(e.target.value)}
                        placeholder="Set new app lock password"
                        className="w-full rounded-md border border-[#E5E7EB] bg-[#F8F9FA] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#3B82F6] transition"
                    />

                    <div className="flex justify-end">
                        <button
                            onClick={handleSaveSecurity}
                            className="rounded-md bg-[#3B82F6] px-4 py-2 text-sm text-white hover:bg-blue-600 transition hover:cursor-pointer"
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
                            Optional future encryption key.
                        </p>
                    </div>

                    <input
                        type="password"
                        value={newJournalSecret}
                        onChange={(e) => setNewJournalSecret(e.target.value)}
                        placeholder="Set journal encryption password"
                        className="w-full rounded-md border border-[#E5E7EB] bg-[#F8F9FA] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#3B82F6] transition"
                    />
                </section>

                {/* Export */}
                <section className="space-y-4 rounded-xl border border-[#E5E7EB] bg-white p-6">
                    <h2 className="text-sm font-medium text-[#1F2933]">
                        Data Export
                    </h2>

                    <button
                        onClick={handleExportAll}
                        className="rounded-md border border-[#E5E7EB] px-4 py-2 text-sm text-[#1F2933] hover:bg-gray-100 transition"
                    >
                        Export all journals
                    </button>
                </section>

                {/* Appearance */}
                <section className="space-y-4 rounded-xl border border-[#E5E7EB] bg-white p-6">
                    <h2 className="text-sm font-medium text-[#1F2933]">
                        Appearance
                    </h2>

                    <div className="space-y-2 text-sm">
                        <label className="flex items-center gap-3">
                            <input
                                type="radio"
                                checked={density === "comfortable"}
                                onChange={() => setDensity("comfortable")}
                            />
                            Comfortable (default)
                        </label>

                        <label className="flex items-center gap-3 text-gray-400">
                            <input type="radio" disabled />
                            Compact (coming soon)
                        </label>
                    </div>
                </section>

                <div className="rounded-xl border border-dashed border-[#E5E7EB] p-6 text-sm text-[#6B7280]">
                    More settings will appear here over time.
                </div>
            </div>

            {toast && <Toast {...toast} />}
        </>
    );
}
