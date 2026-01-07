import { createPortal } from "react-dom";

export default function ConfirmDialog({
    open,
    title,
    message,
    confirmText = "Confirm",
    onCancel,
    onConfirm,
}) {
    if (!open) return null;

    return createPortal(
        <div className="fixed inset-0 z-[900] flex items-center justify-center">
            {/* Backdrop */}
            <div
                className="absolute inset-0 bg-black/30"
                onClick={onCancel}
            />

            {/* Dialog */}
            <div className="relative z-10 w-full max-w-sm p-6 bg-white shadow-xl rounded-xl">
                <h3 className="text-lg font-semibold text-[#1F2933]">
                    {title}
                </h3>

                <p className="mt-2 text-sm text-[#6B7280]">
                    {message}
                </p>

                <div className="flex justify-end gap-3 mt-6">
                    <button
                        onClick={onCancel}
                        className="text-sm px-3 py-1.5 rounded-md border border-[#E5E7EB] text-[#1F2933] hover:bg-gray-100 hover:cursor-pointer transition"
                    >
                        Cancel
                    </button>

                    <button
                        onClick={onConfirm}
                        className="px-4 py-1.5 text-sm rounded-md bg-red-500 text-white hover:bg-red-600 hover:cursor-pointer transition"
                    >
                        {confirmText}
                    </button>
                </div>
            </div>
        </div>,
        document.body
    );
}
