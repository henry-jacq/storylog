import { useState } from "react";
import { SettingsAPI } from "../services/settings";
import { LockClosedIcon } from "@heroicons/react/24/solid";

export default function AppLock({ onUnlock }) {
    const [value, setValue] = useState("");
    const [error, setError] = useState(false);
    const [loading, setLoading] = useState(false);

    async function submit() {
        if (!value || loading) return;

        setLoading(true);
        setError(false);

        try {
            await SettingsAPI.unlock(value);
            await onUnlock();
        } catch {
            setError(true);
            setValue("");
        } finally {
            setLoading(false);
        }
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
                                placeholder="Enter your app lock password"
                                value={value}
                                onChange={e => setValue(e.target.value)}
                                onKeyDown={e => e.key === "Enter" && submit()}
                                autoFocus
                                disabled={loading}
                                className="w-full rounded-md border border-[#E5E7EB] bg-[#F8F9FA] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#3B82F6] transition"
                            />

                            {/* Error Message */}
                            {error && (
                                <p className="text-xs text-red-500">
                                    Incorrect password. Please try again.
                                </p>
                            )}
                        </div>
                    </div>

                    {/* Action Button */}
                    <div className="pt-2">
                        <button
                            onClick={submit}
                            disabled={loading}
                            className="w-full py-3 text-sm font-medium text-white bg-[#3B82F6] rounded-md hover:bg-blue-600 transition hover:cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            {loading ? "Checking…" : "Unlock"}
                        </button>
                    </div>
                </div>

                {/* Footer */}
                <div className="text-center">
                    <p className="text-xs text-[#6B7280]">
                        Your journals stay private and secure
                    </p>
                </div>
            </div>
        </div>
    );
}
