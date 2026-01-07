import { createPortal } from "react-dom";

export default function Toast({ type = "info", message }) {
    return createPortal(
        <div className="fixed bottom-6 left-1/2 -translate-x-1/2 z-[1000]">
            <div
                className={`
                    px-4 py-2 rounded-md text-sm shadow-lg
                    ${type === "success" && "bg-green-600 text-white"}
                    ${type === "error" && "bg-red-600 text-white"}
                    ${type === "info" && "bg-[#1F2933] text-white"}
                `}
            >
                {message}
            </div>
        </div>,
        document.body
    );
}
