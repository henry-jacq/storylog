import SetupProgress from './../../../components/SetupProgress';

export default function WelcomeStep({ onNext, step, total }) {
    return (
        <div className="space-y-6">
            <SetupProgress step={step} total={total} />

            {/* Welcome Content */}
            <div className="text-center space-y-4">
                <div className="space-y-2 mt-10 mb-4">
                    <h1 className="text-xl font-semibold text-[#1F2933]">
                        Welcome to Storylog
                    </h1>
                    <p className="text-sm text-[#6B7280] leading-relaxed">
                        A quiet place to reflect, write and understand your days.
                    </p>
                </div>
            </div>

            {/* Action Button */}
            <div className="pt-2">
                <button
                    onClick={() => onNext()}
                    className="w-full py-3 text-sm font-medium text-white bg-[#3B82F6] rounded-md hover:bg-blue-600 transition hover:cursor-pointer"
                >
                    Get Started
                </button>
            </div>
        </div>
    );
}