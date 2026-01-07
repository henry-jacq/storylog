export default function Loader({ label = "Loading…" }) {
    return (
        <div className="py-12 text-center text-sm text-[#6B7280]">
            {label}
        </div>
    );
}
