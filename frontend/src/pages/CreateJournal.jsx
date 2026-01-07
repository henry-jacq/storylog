export default function CreateJournal() {
    return (
        <section className="max-w-3xl space-y-8">
            <h2 className="text-2xl font-semibold">Write Journal</h2>

            <div className="grid grid-cols-2 gap-6">
                <input className="input" placeholder="Date" />
                <input className="input" placeholder="Time" />
                <input className="input" placeholder="Day" />
                <input className="input" placeholder="Day of year" />
            </div>

            <textarea
                rows={10}
                className="w-full p-4 border rounded-lg"
                placeholder="One thought per line…"
            />

            <button className="px-6 py-3 bg-[#3B82F6] text-white rounded-lg">
                Save Journal
            </button>
        </section>
    );
}
