import { Link } from "react-router-dom";

export default function Home() {
    return (
        <section className="space-y-10">
            <div>
                <h1 className="text-3xl font-semibold">Storylog</h1>
                <p className="mt-2 text-[#6B7280]">
                    Quiet place to think and write about the day.
                </p>
            </div>

            <div className="flex gap-6">
                <Link
                    to="/journals/new"
                    className="px-6 py-3 bg-[#3B82F6] text-white rounded-lg"
                >
                    Write Today
                </Link>

                <Link
                    to="/journals"
                    className="px-6 py-3 border border-[#E5E7EB] rounded-lg"
                >
                    Browse Journals
                </Link>
            </div>

            {/* Future-ready placeholders */}
            <div className="grid grid-cols-2 gap-6 opacity-40">
                <div className="p-6 bg-white border rounded-xl">Journal statistics</div>
                <div className="p-6 bg-white border rounded-xl">Insights</div>
            </div>
        </section>
    );
}
