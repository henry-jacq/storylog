import { useEffect, useState } from "react";
import Toast from "../components/Toast";
import { SettingsAPI } from "../services/settings";
import { clearSessionToken, setSessionToken } from "../services/api";

export default function Settings() {
    // profile (public)
    const [profile, setProfile] = useState(null);

    const [characterPrompt, setCharacterPrompt] = useState("");

    // write-only inputs
    const [oldAppLock, setOldAppLock] = useState("");
    const [newAppLock, setNewAppLock] = useState("");

    // ui-only
    const [toast, setToast] = useState(null);

    useEffect(() => {
        SettingsAPI.getPublic().then(setProfile);
    }, []);

    function notify(message, type = "success") {
        setToast({ type, message });
        setTimeout(() => setToast(null), 2200);
    }

    async function handleSaveSecurity() {
        if (!oldAppLock || !newAppLock) {
            notify("Please enter both old and new passwords", "info");
            return;
        }

        try {
            const response = await SettingsAPI.changePassword(oldAppLock, newAppLock);
            
            // Update session token if provided in response
            if (response && response.session_id) {
                setSessionToken(response.session_id);
            }
            
            setOldAppLock("");
            setNewAppLock("");
            
            const message = response.journals_reencrypted 
                ? "Password changed successfully. All journals have been re-encrypted with your new password."
                : "Password changed successfully.";
            
            notify(message, "success");
            
        } catch (error) {
            notify(error.message || "Failed to change password", "error");
        }
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
                            Change App Lock Password
                        </h2>
                        <p className="mt-1 text-sm text-[#6B7280]">
                            {profile?.app_lock_enabled
                                ? "Update your app lock password. This will re-encrypt all journals."
                                : "Set app lock password to protect your journals"}
                        </p>
                    </div>

                    <div className="space-y-3">
                        <div>
                            <label className="text-sm font-medium text-[#1F2933]">
                                Current Password
                            </label>
                            <input
                                type="password"
                                value={oldAppLock}
                                onChange={(e) => setOldAppLock(e.target.value)}
                                placeholder="Enter current app lock password"
                                className="mt-1 w-full rounded-md border border-[#E5E7EB] bg-[#F8F9FA] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#3B82F6] transition"
                            />
                        </div>

                        <div>
                            <label className="text-sm font-medium text-[#1F2933]">
                                New Password
                            </label>
                            <input
                                type="password"
                                value={newAppLock}
                                onChange={(e) => setNewAppLock(e.target.value)}
                                placeholder="Enter new app lock password"
                                className="mt-1 w-full rounded-md border border-[#E5E7EB] bg-[#F8F9FA] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#3B82F6] transition"
                            />
                        </div>
                    </div>

                    <div className="flex justify-end">
                        <button
                            onClick={handleSaveSecurity}
                            disabled={!oldAppLock || !newAppLock}
                            className="rounded-md bg-[#3B82F6] px-4 py-2 text-sm text-white hover:bg-blue-600 transition hover:cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            Update Password
                        </button>
                    </div>
                </section>

                {/* Journal Encryption Status */}
                <section className="space-y-4 rounded-xl border border-[#E5E7EB] bg-white p-6">
                    <div>
                        <h2 className="text-sm font-medium text-[#1F2933]">
                            Journal Encryption
                        </h2>
                        <p className="mt-1 text-sm text-[#6B7280]">
                            Your journals are automatically encrypted using a secure password derived from your app lock password.
                        </p>
                    </div>

                    <div className="flex items-center space-x-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                        <div className="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center">
                            <svg className="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p className="text-sm font-medium text-green-800">
                                Encryption Active
                            </p>
                            <p className="text-xs text-green-600">
                                Journal content is encrypted at rest
                            </p>
                        </div>
                    </div>

                    <p className="text-xs text-[#6B7280]">
                        Note: Changing your app lock password will automatically re-encrypt all journals with the new derived password.
                    </p>
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

                {/* Character Analysis (Future RAG) */}
                <section className="space-y-4 rounded-xl border border-[#E5E7EB] bg-white p-6">
                    <div>
                        <h2 className="text-sm font-medium text-[#1F2933]">
                            Character Analysis (System Prompt)
                        </h2>
                        <p className="mt-1 text-sm text-[#6B7280]">
                            Define how the AI should analyze your journals and reflect patterns back to you.
                        </p>
                    </div>

                    <textarea
                        value={characterPrompt}
                        onChange={(e) => setCharacterPrompt(e.target.value)}
                        rows={6}
                        placeholder={`Example:
Analyze my journals over time and identify recurring emotional patterns.
If I repeat a mistake I've already written about, remind me of my past conclusions.
Warn me when I drift from values I previously expressed.`}
                        className="w-full resize-none rounded-md border border-[#E5E7EB] bg-[#F8F9FA] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#3B82F6] transition"
                    />

                    <div className="flex items-center justify-between">
                        <p className="text-xs text-[#6B7280]">
                            This will be used when character analysis becomes available.
                        </p>

                        <button
                            disabled
                            className="rounded-md border border-[#E5E7EB] px-4 py-2 text-sm text-gray-400 cursor-not-allowed"
                        >
                            Save Prompt
                        </button>
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
