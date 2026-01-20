import { useState } from "react";
import SetupProgress from './../../../components/SetupProgress';

export default function SecurityStep({ onNext, step, total }) {
    const [appLock, setAppLock] = useState("");
    const [journalSecret, setJournalSecret] = useState("");

    return (
        <>
            <SetupProgress step={step} total={total} />

            <h2 className="text-xl font-semibold">Security</h2>

            <div className="space-y-2">
                <label className="text-sm">App Lock Password</label>
                <input
                    type="password"
                    value={appLock}
                    onChange={e => setAppLock(e.target.value)}
                    className="w-full px-3 py-2 border rounded-md"
                />
            </div>

            <div className="space-y-2">
                <label className="text-sm">
                    Journal Encryption Password (optional)
                </label>
                <input
                    type="password"
                    value={journalSecret}
                    onChange={e => setJournalSecret(e.target.value)}
                    className="w-full px-3 py-2 border rounded-md"
                />
            </div>

            <button
                onClick={() =>
                    onNext({
                        appLockEnabled: !!appLock,
                        appLockSecret: appLock,
                        journalSecret,
                    })
                }
                className="w-full py-2 text-white bg-blue-500 rounded-md"
            >
                Continue
            </button>
        </>
    );
}
