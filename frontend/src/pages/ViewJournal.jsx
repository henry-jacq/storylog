export default function ViewJournal() {
    return (
        <section className="max-w-3xl space-y-6">
            <h2 className="text-2xl font-semibold">Journal</h2>

            <div className="p-6 bg-white border rounded-xl">
                Journal content
            </div>

            <div className="flex gap-4">
                <button className="text-sm underline">Edit</button>
                <button className="text-sm text-red-500 underline">Delete</button>
            </div>
        </section>
    );
}
