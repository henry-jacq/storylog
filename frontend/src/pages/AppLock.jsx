import { useState, useEffect } from "react";
import { SettingsAPI } from "../services/settings";
import { LockClosedIcon } from "@heroicons/react/24/solid";
import { setSessionToken } from "../services/api";

export default function AppLock({ onUnlock }) {
    const [password, setPassword] = useState("");
    const [error, setError] = useState("");
    const [loading, setLoading] = useState(false);
    const [checkingAuth, setCheckingAuth] = useState(true);
    const [encryptionEnabled, setEncryptionEnabled] = useState(false);

    // Check if encryption is enabled
    useEffect(() => {
        const checkAuthStatus = async () => {
            try {
                const publicSettings = await SettingsAPI.getPublic();
                setEncryptionEnabled(publicSettings.journal_encryption_enabled);
            } catch (e) {
                console.error("Failed to check auth status:", e);
                setEncryptionEnabled(false);
            } finally {
                setCheckingAuth(false);
            }
        };

        checkAuthStatus();
    }, []);

    async function submit() {
        if (!password || loading) return;

        setLoading(true);
        setError("");

        try {
            const response = await SettingsAPI.unlock(password);
            
            // Store session token if provided
            if (response && response.session_id) {
                setSessionToken(response.session_id);
            }
            
            await onUnlock();
        } catch (err) {
            setError(err.message || "Authentication failed");
            // Clear password on error
            setPassword("");
        } finally {
            setLoading(false);
        }
    }

    if (checkingAuth) {
        return (
            <div className="min-h-screen bg-[#F8F9FA] flex items-center justify-center px-4">
                <div className="text-center">
                    <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-[#3B82F6] mx-auto"></div>
                    <p className="mt-4 text-sm text-[#6B7280]">Checking authentication requirements...</p>
                </div>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-[#F8F9FA] flex items-center justify-center px-4">
            <div className="w-full max-w-md space-y-6">
                {/* Main Card Container */}
                <div className="bg-white border border-[#E5E7EB] rounded-xl p-8 space-y-6">
                    {/* Header */}
                    <div className="text-center space-y-4">
                        {/* Lock Icon */}
                        <div className="flex justify-center">
                            <div className="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                <LockClosedIcon className="w-8 h-8 text-[#3B82F6]" />
                            </div>
                        </div>

                        {/* Title and Description */}
                        <div className="space-y-2">
                            <h1 className="text-xl font-semibold text-[#1F2933]">
                                App Locked
                            </h1>
                            <p className="text-sm text-[#6B7280] leading-relaxed">
                                Enter your password to access Storylog
                            </p>
                        </div>
                    </div>

                    {/* Form */}
                    <div className="space-y-4">
                        {/* Password Input */}
                        <div className="space-y-2">
                            <label className="text-sm font-medium text-[#1F2933]">
                                Password
                            </label>
                            <input
                                type="password"
                                placeholder="Enter your password"
                                value={password}
                                onChange={e => setPassword(e.target.value)}
                                onKeyDown={e => e.key === "Enter" && submit()}
                                autoFocus
                                disabled={loading}
                                className="w-full rounded-md border border-[#E5E7EB] bg-[#F8F9FA] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#3B82F6] transition"
                            />

                            {/* Error Message */}
                            {error && (
                                <p className="text-xs text-red-500">
                                    {error}
                                </p>
                            )}
                        </div>
                    </div>

                    {/* Action Button */}
                    <div className="pt-2">
                        <button
                            onClick={submit}
                            disabled={loading || !password}
                            className="w-full py-3 text-sm font-medium text-white bg-[#3B82F6] rounded-md hover:bg-blue-600 transition hover:cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            {loading ? "Unlocking..." : "Unlock"}
                        </button>
                        {encryptionEnabled && (
                            <span className="text-xs block mt-2 text-green-600">
                                Journal Encryption is Enabled - Your Journals are Secure
                            </span>
                        )}
                    </div>
                </div>

                {/* Footer */}
                <div className="text-center space-y-2">
                    <p className="text-xs text-[#6B7280]">
                        Your journals stay private and secure
                    </p>
                </div>
            </div>
        </div>
    );
}
