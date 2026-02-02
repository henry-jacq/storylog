import { Link, useNavigate } from "react-router-dom";
import { useEffect, useState } from "react";
import { JournalsAPI } from "../services/journals";
import {
    Cog6ToothIcon,
    BookOpenIcon,
    PencilSquareIcon,
    FireIcon,
    CalendarDaysIcon,
    ShieldCheckIcon,
    ChatBubbleLeftRightIcon
} from "@heroicons/react/24/outline";

/* Base Stat Card (Factual) */
function StatCard({ label, value, icon: Icon, suffix }) {
    return (
        <div className="p-5 bg-white border border-gray-200 rounded-xl">
            <div className="flex items-center justify-between">
                <p className="text-base text-gray-500">{label}</p>
                <Icon className="w-5 h-5 text-gray-400" />
            </div>

            <div className="mt-3 text-xl font-semibold text-gray-900">
                {value ?? "—"}
                {suffix && (
                    <span className="ml-1 text-base font-medium text-gray-600">
                        {suffix}
                    </span>
                )}
            </div>
        </div>
    );
}

/* Insight Card (Interpretive) */
function InsightStatCard({ label, value, icon: Icon, helper }) {
    return (
        <div className="p-5 border border-gray-200 bg-gradient-to-br from-gray-50 to-white rounded-xl">
            <div className="flex items-center justify-between">
                <p className="text-sm font-medium text-gray-600">{label}</p>
                <Icon className="w-5 h-5 text-gray-400" />
            </div>

            <div className="mt-3 text-2xl font-semibold text-gray-900">
                {value ?? "—"}
            </div>

            {helper && (
                <p className="mt-1 text-sm text-gray-500">
                    {helper}
                </p>
            )}
        </div>
    );
}

/* Yearly Breakdown (Trends) */
function YearlyBreakdown({ title, data }) {
    if (!data) return null;

    return (
        <div className="p-6 bg-white border border-gray-200 rounded-xl">
            <h4 className="text-base font-semibold text-gray-700">
                {title}
            </h4>

            <div className="mt-4 space-y-2">
                {Object.entries(data).map(([year, value]) => (
                    <div
                        key={year}
                        className="flex justify-between text-sm text-gray-600"
                    >
                        <span>{year}</span>
                        <span className="font-medium text-gray-900">
                            {new Intl.NumberFormat().format(value)}
                        </span>
                    </div>
                ))}
            </div>
        </div>
    );
}

/* Future RAG Placeholder */
function InfoCard() {
    return (
        <div className="p-6 border border-gray-300 border-dashed bg-gray-50 rounded-xl">
            <div className="flex items-start justify-between">
                <div>
                    <h3 className="text-lg font-semibold text-gray-900">
                        Character Analysis
                    </h3>
                    <p className="mt-1 text-sm text-gray-500">
                        AI-powered understanding of your mindset over time.
                    </p>
                </div>

                <span className="px-2 py-1 text-xs text-gray-600 bg-gray-200 rounded-full">
                    Coming Soon
                </span>
            </div>

            <div className="mt-6 space-y-4">
                <p className="text-sm text-gray-500">
                    Below are default prompts for users to ask
                </p>
                <p className="text-sm text-gray-500">
                    Also Provide some system prompts on settings page regarding this
                </p>
                <p className="text-sm text-gray-500">
                    System prompt be like: Remind me if i choose the different path like you said something like this happened then you shouldn't do this something like that.
                </p>
                <p className="text-sm text-gray-500">
                    • Emotional trends across selected periods
                </p>
                <p className="text-sm text-gray-500">
                    • Recurring traits and themes
                </p>
                <p className="text-sm text-gray-500">
                    • Notable shifts in perspective
                </p>
            </div>

            <button
                disabled
                className="w-full px-4 py-2 mt-6 text-sm font-medium text-gray-400 border border-gray-300 rounded-lg cursor-not-allowed"
            >
                Analyze Journals
            </button>
        </div>
    );
}

/*Home Page */
export default function Home() {
    const [stats, setStats] = useState(null);
    const [insights, setInsights] = useState(null);
    const navigate = useNavigate();

    useEffect(() => {
        JournalsAPI.stats().then(setStats);
        JournalsAPI.insights().then(setInsights);
    }, []);

    function lockNow() {
        navigate("/", {
            replace: true,
            state: { lockNow: true },
        });
    }

    return (
        <section className="space-y-10">
            {/* Header */}
            <div className="flex items-center justify-between">
                <div>
                    <h1 className="text-3xl font-semibold text-gray-900">
                        Storylog
                    </h1>
                    <p className="mt-2 text-gray-500">
                        Quiet place to think and write about the day.
                    </p>
                </div>

                <div className="flex gap-4">
                    {/* Manual App Lock */}
                    <button
                        onClick={lockNow}
                        title="Lock app"
                        className="p-2 transition border border-gray-200 rounded-lg hover:bg-gray-50 hover:cursor-pointer"
                    >
                        <ShieldCheckIcon className="w-5 h-5 text-gray-600" />
                    </button>

                    {/* Settings */}
                    <Link
                        to="/settings"
                        className="p-2 transition border border-gray-200 rounded-lg hover:bg-gray-50"
                    >
                        <Cog6ToothIcon className="w-5 h-5 text-gray-600" />
                    </Link>
                </div>
            </div>

            {/* Actions */}
            <div className="flex gap-4">
                <Link
                    to="/journals/new"
                    className="px-6 py-3 font-medium text-white transition bg-blue-500 rounded-lg hover:bg-blue-600"
                >
                    Write Today
                </Link>

                <Link
                    to="/journals"
                    className="px-6 py-3 font-medium transition border border-gray-200 rounded-lg hover:bg-gray-50"
                >
                    Browse Journals
                </Link>

                <Link
                    to="/quotes"
                    className="px-6 py-3 font-medium transition border border-gray-200 rounded-lg hover:bg-gray-50"
                >
                    Quotes
                </Link>
            </div>

            {/* Stats */}
            <div className="mt-12">
                <h2 className="text-xl font-semibold text-gray-900">
                    Your Stats
                </h2>
                <p className="mt-2 text-gray-500">
                    Overview of your journaling habits and milestones.
                </p>
            </div>

            <div className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <StatCard label="Total Journals" value={stats?.total_journals} icon={BookOpenIcon} />
                <StatCard label="Total Words" value={new Intl.NumberFormat().format(stats?.total_words)} icon={PencilSquareIcon} />
                <StatCard label="Total Days" value={stats?.total_days} icon={CalendarDaysIcon} />
                <StatCard label="Last Entry" value={stats?.last_entry} icon={CalendarDaysIcon} />
                <StatCard label="Current Streak" value={stats?.current_streak} suffix="days" icon={FireIcon} />
                <StatCard label="Longest Streak" value={stats?.longest_streak} suffix="days" icon={FireIcon} />
            </div>

            {/* Insights */}
            <div className="mt-12">
                <h2 className="text-xl font-semibold text-gray-900">
                    Insights
                </h2>
                <p className="mt-2 text-gray-500">
                    Patterns and habits discovered from your journals.
                </p>

                <div className="grid grid-cols-1 gap-6 mt-6 sm:grid-cols-2 lg:grid-cols-3">
                    <InsightStatCard
                        label="Avg Words per Entry"
                        value={insights?.avg_words_per_entry?.toFixed(1)}
                        helper="Typical length of your journal entries"
                        icon={PencilSquareIcon}
                    />

                    <InsightStatCard
                        label="Most Active Year"
                        value={insights?.most_active_year}
                        helper="Year you wrote the most"
                        icon={CalendarDaysIcon}
                    />

                    <InsightStatCard
                        label="Busiest Writing Day"
                        value={insights?.busiest_weekday}
                        helper="Day you journal most often"
                        icon={FireIcon}
                    />
                </div>

                <div className="grid grid-cols-1 gap-6 mt-6 lg:grid-cols-2">
                    <YearlyBreakdown
                        title="Journals per Year"
                        data={insights?.journals_per_year}
                    />

                    <YearlyBreakdown
                        title="Words per Year"
                        data={insights?.words_per_year}
                    />
                </div>
            </div>

            {/* Future RAG */}
            <div className="mt-12">
                <InfoCard />
            </div>
        </section>
    );
}
