export default function EmptyState({
    title,
    description,
    actionLabel,
    onAction,
}) {
    return (
        <div className="py-20 text-center space-y-4">
            <h3 className="text-lg font-medium text-[#1F2933]">
                {title}
            </h3>
            <p className="text-sm text-[#6B7280] max-w-md mx-auto">
                {description}
            </p>

            {onAction && (
                <button
                    onClick={onAction}
                    className="mt-4 px-4 py-2 text-sm rounded-md
                     bg-[#3B82F6] text-white
                     hover:bg-blue-600 transition"
                >
                    {actionLabel}
                </button>
            )}
        </div>
    );
}
