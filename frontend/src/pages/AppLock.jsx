import { useState } from "react";

export default function AppLock({ secret, onUnlock }) {
    const [value, setValue] = useState("");
    const [error, setError] = useState(false);

    function submit() {
        if (value === secret) {
            onUnlock();
        } else {
            setError(true);
            setValue("");
        }
    }

    return (
        <div className="min-h-screen bg-[#F8F9FA] flex items-center justify-center px-4">
            <div className="w-full max-w-sm p-6 space-y-4 bg-white border rounded-xl">
                <h1 className="text-xl font-semibold text-[#1F2933]">
                    App Locked
                </h1>

                <p className="text-sm text-[#6B7280]">
                    Enter your app password to continue.
                </p>

                <input
                    type="password"
                    value={value}
                    onChange={e => setValue(e.target.value)}
                    onKeyDown={e => e.key === "Enter" && submit()}
                    autoFocus
                    className={`
                        w-full px-3 py-2 rounded-md border text-sm
                        focus:outline-none focus:ring-2
                        ${error
                            ? "border-red-400 focus:ring-red-300"
                            : "border-[#E5E7EB] focus:ring-[#3B82F6]"
                        }
                    `}
                />

                {error && (
                    <p className="text-xs text-red-500">
                        Incorrect password
                    </p>
                )}

                <button
                    onClick={submit}
                    className="w-full py-2 text-sm text-white bg-[#3B82F6] rounded-md hover:bg-blue-600 transition"
                >
                    Unlock
                </button>
            </div>
        </div>
    );
}
