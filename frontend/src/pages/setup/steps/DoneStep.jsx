import SetupProgress from './../../../components/SetupProgress';

export default function DoneStep({ onFinish, step, total }) {
    return (
        <div className="space-y-6">
            <SetupProgress step={step} total={total} />

            {/* Success Content */}
            <div className="text-center space-y-4">
                {/* Success Icon */}
                <div className="flex justify-center">
                    <div className="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                        <svg className="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>

                {/* Success Message */}
                <div className="space-y-2">
                    <h2 className="text-xl font-semibold text-[#1F2933]">
                        You're all set!
                    </h2>
                    <p className="text-sm text-[#6B7280] leading-relaxed">
                        Storylog is ready. Your journals stay private and local.
                    </p>
                </div>
            </div>

            {/* Action Button */}
            <div className="pt-2">
                <button
                    onClick={onFinish}
                    className="w-full py-3 text-sm font-medium text-white bg-[#3B82F6] rounded-md hover:bg-blue-600 transition hover:cursor-pointer"
                >
                    Start Writing
                </button>
            </div>
        </div>
    );
}
