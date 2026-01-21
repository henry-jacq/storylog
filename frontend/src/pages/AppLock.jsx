import { useState } from "react";
import { SettingsAPI } from "../services/settings";

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
            <div className="w-full max-w-md p-6 space-y-2 bg-white border border-[#F8F9FA] rounded-xl">
                <h1 className="text-xl font-semibold text-[#1F2933] mb-2">
                    App Locked
                </h1>
                <p className="text-sm text-[#6B7280] mb-6">Enter your credentials to access storylog</p>

                <input
                    type="password"
                    value={value}
                    onChange={e => setValue(e.target.value)}
                    onKeyDown={e => e.key === "Enter" && submit()}
                    autoFocus
                    disabled={loading}
                    className="w-full rounded-md border border-[#E5E7EB] bg-[#F8F9FA] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#3B82F6] transition"
                />

                {error && (
                    <p className="text-xs text-red-500">
                        Incorrect password
                    </p>
                )}

                <button
                    onClick={submit}
                    disabled={loading}
                    className="w-full py-2 mt-4 text-sm text-white bg-blue-500 rounded-md hover:bg-blue-600 hover:cursor-pointer">
                    {loading ? "Checking…" : "Unlock"}
                </button>
            </div>
        </div>
    );
}
