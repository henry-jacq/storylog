export default function Toast({ message, type = "success" }) {
    return (
        <div
            className={`fixed bottom-6 right-6 px-4 py-3 rounded-md shadow-sm text-sm
        ${type === "success"
                    ? "bg-[#3B82F6] text-white"
                    : "bg-red-500 text-white"}`}
        >
            {message}
        </div>
    );
}
