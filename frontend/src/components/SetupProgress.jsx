export default function SetupProgress({ step, total }) {
    const progressPercentage = (step / total) * 100;
    
    return (
        <div className="space-y-3">
            {/* Progress Bar */}
            <div className="flex items-center justify-between text-xs text-[#6B7280]">
                <span>Step {step} of {total}</span>
                <span>{Math.round(progressPercentage)}%</span>
            </div>
            
            {/* Visual Progress Bar */}
            <div className="w-full bg-[#E5E7EB] rounded-full h-1.5">
                <div 
                    className="bg-[#3B82F6] h-1.5 rounded-full transition-all duration-300 ease-out"
                    style={{ width: `${progressPercentage}%` }}
                />
            </div>
        </div>
    );
}