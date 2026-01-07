export default function JournalCard({
    journal,
    selected,
    onSelect,
    onOpen,
}) {
    return (
        <div
            className={`p-4 rounded-lg border transition
        ${selected
                    ? "border-[#3B82F6] bg-blue-50"
                    : "border-[#E5E7EB] bg-white"}
      `}
        >
            <div className="flex items-start gap-4">
                {/* Selection */}
                <input
                    type="checkbox"
                    checked={selected}
                    onChange={onSelect}
                    className="mt-1 cursor-pointer"
                />

                {/* Clickable content only */}
                <div
                    onClick={onOpen}
                    className="flex-1 space-y-1 cursor-pointer hover:opacity-90"
                >
                    <div className="text-sm font-medium text-[#1F2933]">
                        {journal.journal_date} · {journal.day}
                    </div>

                    <div className="text-xs text-[#6B7280]">
                        {journal.journal_time} · Day {journal.day_of_year}
                    </div>

                    <div className="text-sm text-[#6B7280] line-clamp-2">
                        {journal.content_md.replace(/^- /gm, "")}
                    </div>
                </div>
            </div>
        </div>
    );
}
