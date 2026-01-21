import { useState } from "react";
import SetupProgress from './../../../components/SetupProgress';

export default function SecurityStep({ onNext, step, total }) {
    const [appLock, setAppLock] = useState("");
    const [journalSecret, setJournalSecret] = useState("");

    return (
        <div className="space-y-6">
            <SetupProgress step={step} total={total} />

            {/* Header */}
            <div className="space-y-2">
                <h2 className="text-xl font-semibold text-[#1F2933]">
                    Security
                </h2>
                <p className="text-sm text-[#6B7280]">
                    Keep your journals private and secure
                </p>
            </div>

            {/* Security Options */}
            <div className="space-y-6">
                {/* App Lock */}
                <div className="space-y-3">
                    <label className="text-sm font-medium text-[#1F2933]">
                        App Lock Password
                    </label>
                    <input
                        type="password"
                        placeholder="Create app lock password"
                        value={appLock}
                        onChange={e => setAppLock(e.target.value)}
                        className="my-1 w-full rounded-md border border-[#E5E7EB] bg-[#F8F9FA] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#3B82F6] transition"
                    />
                    <p className="text-xs text-[#6B7280]">
                        Locks the app after 5 minutes of inactivity
                    </p>
                </div>

                {/* Journal Encryption */}
                <div className="space-y-3">
                    <label className="text-sm font-medium text-[#1F2933]">
                        Journal Encryption Password (optional)
                    </label>
                    <input
                        type="password"
                        placeholder="Create encryption password"
                        value={journalSecret}
                        onChange={e => setJournalSecret(e.target.value)}
                        className="my-1 w-full rounded-md border border-[#E5E7EB] bg-[#F8F9FA] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#3B82F6] transition"
                    />
                    <p className="text-xs text-[#6B7280]">
                        Encrypt your journal contents
                    </p>
                </div>
            </div>

            {/* Action Button */}
            <div className="pt-2">
                <button
                    onClick={() =>
                        onNext({
                            appLockEnabled: !!appLock,
                            appLockSecret: appLock,
                            journalSecret,
                        })
                    }
                    className="w-full py-3 text-sm font-medium text-white bg-[#3B82F6] rounded-md hover:bg-blue-600 transition hover:cursor-pointer"
                >
                    Continue
                </button>
            </div>
        </div>
    );
}
