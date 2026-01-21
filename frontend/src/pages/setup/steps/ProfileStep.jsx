import { useState } from 'react';
import SetupProgress from './../../../components/SetupProgress';

export default function ProfileStep({ data, onNext, step, total }) {
    const [name, setName] = useState(data.name || "");
    const [email, setEmail] = useState(data.email || "");
    
    return (
        <div className="space-y-6">
            <SetupProgress step={step} total={total} />

            {/* Header */}
            <div className="space-y-2">
                <h2 className="text-xl font-semibold text-[#1F2933]">
                    About you
                </h2>
                <p className="text-sm text-[#6B7280]">
                    Help personalize your experience (optional)
                </p>
            </div>

            {/* Form Fields */}
            <div className="space-y-4">
                <div className="space-y-2">
                    <label className="text-sm font-medium text-[#1F2933]">
                        Name
                    </label>
                    <input
                        type="text"
                        placeholder="Enter your name"
                        value={name}
                        onChange={e => setName(e.target.value)}
                        className="w-full rounded-md border border-[#E5E7EB] bg-[#F8F9FA] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#3B82F6] transition"
                    />
                </div>

                <div className="space-y-2">
                    <label className="text-sm font-medium text-[#1F2933]">
                        Email
                    </label>
                    <input
                        type="email"
                        placeholder="Enter your email"
                        value={email}
                        onChange={e => setEmail(e.target.value)}
                        className="w-full rounded-md border border-[#E5E7EB] bg-[#F8F9FA] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#3B82F6] transition"
                    />
                </div>
            </div>

            {/* Action Button */}
            <div className="pt-2">
                <button
                    onClick={() => onNext({name, email})}
                    className="w-full py-3 text-sm font-medium text-white bg-[#3B82F6] rounded-md hover:bg-blue-600 transition hover:cursor-pointer"
                >
                    Continue
                </button>
            </div>
        </div>
    );
}
