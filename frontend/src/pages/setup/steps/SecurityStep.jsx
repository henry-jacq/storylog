import { useState } from "react";
import SetupProgress from './../../../components/SetupProgress';

export default function SecurityStep({ onNext, step, total }) {
    const [appLock, setAppLock] = useState("");

    return (
        <div className="space-y-6">
            <SetupProgress step={step} total={total} />

            {/* Header */}
            <div className="space-y-2">
                <h2 className="text-xl font-semibold text-[#1F2933]">
                    Security
                </h2>
                <p className="text-sm text-[#6B7280]">
                    Set up your app lock password. Journal encryption is automatically enabled.
                </p>
            </div>

            {/* Security Options */}
            <div className="space-y-6">
                {/* App Lock */}
                <div className="space-y-3">
                    <label className="text-sm font-medium text-[#1F2933]">
                        App Lock Password <span className="text-red-500">*</span>
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

                {/* Journal Encryption Info */}
                <div className="space-y-3 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div className="flex items-center space-x-2">
                        <div className="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center">
                            <svg className="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fillRule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd" />
                            </svg>
                        </div>
                        <label className="text-sm font-medium text-[#1F2933]">
                            Journal Encryption
                        </label>
                    </div>
                    <p className="text-sm text-[#6B7280]">
                        Your journals will be automatically encrypted using a secure password derived from your app lock password. No additional setup needed.
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
                        })
                    }
                    disabled={!appLock}
                    className="w-full py-3 text-sm font-medium text-white bg-[#3B82F6] rounded-md hover:bg-blue-600 transition hover:cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Continue
                </button>
            </div>
        </div>
    );
}
