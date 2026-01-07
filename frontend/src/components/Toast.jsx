export default function Toast({ message, type = "success" }) {
    return (
        <div
            className={`fixed bottom-6 left-1/2 -translate-x-1/2 px-4 py-2 rounded-md text-sm shadow
        ${type === "error"
                    ? "bg-red-500 text-white"
                    : "bg-[#1F2933] text-white"}
      `}
        >
            {message}
        </div>
    );
}
