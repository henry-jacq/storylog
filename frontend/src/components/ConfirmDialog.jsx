export default function ConfirmDialog({
    open,
    title,
    message,
    confirmText = "Confirm",
    cancelText = "Cancel",
    onConfirm,
    onCancel,
}) {
    if (!open) return null;

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/20">
            <div className="w-full max-w-sm p-6 bg-white shadow-lg rounded-xl">
                <h3 className="text-lg font-semibold text-[#1F2933]">
                    {title}
                </h3>

                <p className="mt-2 text-sm text-[#6B7280]">
                    {message}
                </p>

                <div className="flex justify-end gap-3 mt-6">
                    <button
                        onClick={onCancel}
                        className="px-3 py-1.5 text-sm text-[#1F2933] border border-[#E5E7EB] rounded-md hover:bg-gray-100"
                    >
                        {cancelText}
                    </button>

                    <button
                        onClick={onConfirm}
                        className="px-3 py-1.5 text-sm text-white bg-red-500 rounded-md hover:bg-red-600"
                    >
                        {confirmText}
                    </button>
                </div>
            </div>
        </div>
    );
}
