import { useState } from "react";
import {
    ChatBubbleLeftRightIcon,
    HeartIcon,
    BookmarkIcon,
    ShareIcon,
    MagnifyingGlassIcon,
    FunnelIcon,
    PlusIcon
} from "@heroicons/react/24/outline";
import { HeartIcon as HeartSolidIcon, BookmarkIcon as BookmarkSolidIcon } from "@heroicons/react/24/solid";

const dummyQuotes = [
    {
        id: 1,
        text: "The only way to do great work is to love what you do. If you haven't found it yet, keep looking. Don't settle.",
        author: "Steve Jobs",
        source: "Stanford Commencement Address, 2005",
        category: "Motivation",
        tags: ["work", "passion", "success"],
        isLiked: false,
        isSaved: true,
        dateAdded: "2024-01-15"
    },
    {
        id: 2,
        text: "In the end, we only regret the chances we didn't take, the words we didn't say, and the dreams we didn't pursue.",
        author: "Lewis Carroll",
        source: "Alice's Adventures in Wonderland",
        category: "Life Lessons",
        tags: ["regret", "opportunity", "courage"],
        isLiked: true,
        isSaved: false,
        dateAdded: "2024-01-20"
    },
    {
        id: 3,
        text: "The future belongs to those who believe in the beauty of their dreams.",
        author: "Eleanor Roosevelt",
        source: "Public Speech, 1945",
        category: "Inspiration",
        tags: ["dreams", "future", "belief"],
        isLiked: false,
        isSaved: false,
        dateAdded: "2024-02-01"
    },
    {
        id: 4,
        text: "It is during our darkest moments that we must focus to see the light.",
        author: "Aristotle",
        source: "Nicomachean Ethics",
        category: "Philosophy",
        tags: ["hope", "adversity", "strength"],
        isLiked: true,
        isSaved: true,
        dateAdded: "2024-02-10"
    },
    {
        id: 5,
        text: "The only impossible journey is the one you never begin.",
        author: "Tony Robbins",
        source: "Unleash the Power Within",
        category: "Self-Help",
        tags: ["action", "journey", "beginning"],
        isLiked: false,
        isSaved: false,
        dateAdded: "2024-02-15"
    },
    {
        id: 6,
        text: "Success is not final, failure is not fatal: it is the courage to continue that counts.",
        author: "Winston Churchill",
        source: "Speech to the House of Commons, 1942",
        category: "Leadership",
        tags: ["success", "failure", "courage"],
        isLiked: true,
        isSaved: false,
        dateAdded: "2024-02-20"
    }
];

const categories = ["All", "Motivation", "Life Lessons", "Inspiration", "Philosophy", "Self-Help", "Leadership"];

export default function Quotes() {
    const [quotes, setQuotes] = useState(dummyQuotes);
    const [searchTerm, setSearchTerm] = useState("");
    const [selectedCategory, setSelectedCategory] = useState("All");
    const [showAddModal, setShowAddModal] = useState(false);

    const filteredQuotes = quotes.filter(quote => {
        const matchesSearch = quote.text.toLowerCase().includes(searchTerm.toLowerCase()) ||
                             quote.author.toLowerCase().includes(searchTerm.toLowerCase()) ||
                             quote.tags.some(tag => tag.toLowerCase().includes(searchTerm.toLowerCase()));
        const matchesCategory = selectedCategory === "All" || quote.category === selectedCategory;
        return matchesSearch && matchesCategory;
    });

    const toggleLike = (id) => {
        setQuotes(quotes.map(quote => 
            quote.id === id ? { ...quote, isLiked: !quote.isLiked } : quote
        ));
    };

    const toggleSave = (id) => {
        setQuotes(quotes.map(quote => 
            quote.id === id ? { ...quote, isSaved: !quote.isSaved } : quote
        ));
    };

    return (
        <section className="space-y-8">
            {/* Header */}
            <div className="flex items-center justify-between">
                <div>
                    <h1 className="text-3xl font-semibold text-gray-900">
                        Quotes Collection
                    </h1>
                    <p className="mt-2 text-gray-500">
                        Inspiring quotes to motivate and guide your journaling journey.
                    </p>
                </div>
                <button
                    onClick={() => setShowAddModal(true)}
                    className="flex items-center gap-2 px-4 py-2 font-medium text-white transition bg-blue-500 rounded-lg hover:bg-blue-600"
                >
                    <PlusIcon className="w-4 h-4" />
                    Add Quote
                </button>
            </div>

            {/* Search and Filters */}
            <div className="flex flex-col gap-4 sm:flex-row">
                <div className="relative flex-1">
                    <MagnifyingGlassIcon className="absolute left-3 top-1/2 w-5 h-5 text-gray-400 -translate-y-1/2" />
                    <input
                        type="text"
                        placeholder="Search quotes, authors, or tags..."
                        value={searchTerm}
                        onChange={(e) => setSearchTerm(e.target.value)}
                        className="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>
                <div className="flex gap-2">
                    <select
                        value={selectedCategory}
                        onChange={(e) => setSelectedCategory(e.target.value)}
                        className="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        {categories.map(category => (
                            <option key={category} value={category}>{category}</option>
                        ))}
                    </select>
                </div>
            </div>

            {/* Stats */}
            <div className="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div className="p-4 bg-white border border-gray-200 rounded-lg">
                    <div className="flex items-center justify-between">
                        <span className="text-sm text-gray-500">Total Quotes</span>
                        <ChatBubbleLeftRightIcon className="w-5 h-5 text-gray-400" />
                    </div>
                    <div className="mt-2 text-2xl font-semibold text-gray-900">
                        {quotes.length}
                    </div>
                </div>
                <div className="p-4 bg-white border border-gray-200 rounded-lg">
                    <div className="flex items-center justify-between">
                        <span className="text-sm text-gray-500">Liked</span>
                        <HeartIcon className="w-5 h-5 text-gray-400" />
                    </div>
                    <div className="mt-2 text-2xl font-semibold text-gray-900">
                        {quotes.filter(q => q.isLiked).length}
                    </div>
                </div>
                <div className="p-4 bg-white border border-gray-200 rounded-lg">
                    <div className="flex items-center justify-between">
                        <span className="text-sm text-gray-500">Saved</span>
                        <BookmarkIcon className="w-5 h-5 text-gray-400" />
                    </div>
                    <div className="mt-2 text-2xl font-semibold text-gray-900">
                        {quotes.filter(q => q.isSaved).length}
                    </div>
                </div>
            </div>

            {/* Quotes Grid */}
            <div className="space-y-6">
                {filteredQuotes.length === 0 ? (
                    <div className="text-center py-12">
                        <ChatBubbleLeftRightIcon className="w-12 h-12 text-gray-300 mx-auto mb-4" />
                        <p className="text-gray-500">No quotes found matching your criteria.</p>
                    </div>
                ) : (
                    filteredQuotes.map(quote => (
                        <div key={quote.id} className="p-6 bg-white border border-gray-200 rounded-xl">
                            <div className="flex items-start justify-between">
                                <div className="flex-1">
                                    <blockquote className="text-lg text-gray-900 leading-relaxed">
                                        "{quote.text}"
                                    </blockquote>
                                    <div className="mt-4 flex items-center gap-4 text-sm text-gray-600">
                                        <span className="font-medium">— {quote.author}</span>
                                        {quote.source && (
                                            <span className="text-gray-400">• {quote.source}</span>
                                        )}
                                    </div>
                                    <div className="mt-3 flex items-center gap-4">
                                        <span className="px-2 py-1 text-xs font-medium text-blue-600 bg-blue-50 rounded-full">
                                            {quote.category}
                                        </span>
                                        <div className="flex gap-2">
                                            {quote.tags.map(tag => (
                                                <span key={tag} className="text-xs text-gray-500">
                                                    #{tag}
                                                </span>
                                            ))}
                                        </div>
                                    </div>
                                </div>
                                <div className="flex gap-2 ml-4">
                                    <button
                                        onClick={() => toggleLike(quote.id)}
                                        className="p-2 transition rounded-lg hover:bg-gray-50"
                                        title={quote.isLiked ? "Unlike" : "Like"}
                                    >
                                        {quote.isLiked ? (
                                            <HeartSolidIcon className="w-5 h-5 text-red-500" />
                                        ) : (
                                            <HeartIcon className="w-5 h-5 text-gray-400" />
                                        )}
                                    </button>
                                    <button
                                        onClick={() => toggleSave(quote.id)}
                                        className="p-2 transition rounded-lg hover:bg-gray-50"
                                        title={quote.isSaved ? "Unsave" : "Save"}
                                    >
                                        {quote.isSaved ? (
                                            <BookmarkSolidIcon className="w-5 h-5 text-blue-500" />
                                        ) : (
                                            <BookmarkIcon className="w-5 h-5 text-gray-400" />
                                        )}
                                    </button>
                                    <button
                                        className="p-2 transition rounded-lg hover:bg-gray-50"
                                        title="Share quote"
                                    >
                                        <ShareIcon className="w-5 h-5 text-gray-400" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    ))
                )}
            </div>

            {/* Add Quote Modal (Placeholder) */}
            {showAddModal && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
                    <div className="bg-white rounded-xl p-6 max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                        <h2 className="text-xl font-semibold text-gray-900 mb-4">Add New Quote</h2>
                        <div className="space-y-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Quote Text
                                </label>
                                <textarea
                                    className="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    rows={3}
                                    placeholder="Enter the quote..."
                                />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Author
                                </label>
                                <input
                                    type="text"
                                    className="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Author name..."
                                />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Source (Optional)
                                </label>
                                <input
                                    type="text"
                                    className="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Book, speech, etc..."
                                />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Category
                                </label>
                                <select className="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    {categories.filter(cat => cat !== "All").map(category => (
                                        <option key={category} value={category}>{category}</option>
                                    ))}
                                </select>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Tags (comma separated)
                                </label>
                                <input
                                    type="text"
                                    className="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="motivation, success, life..."
                                />
                            </div>
                        </div>
                        <div className="flex gap-3 mt-6">
                            <button
                                onClick={() => setShowAddModal(false)}
                                className="flex-1 px-4 py-2 font-medium text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-50"
                            >
                                Cancel
                            </button>
                            <button
                                onClick={() => setShowAddModal(false)}
                                className="flex-1 px-4 py-2 font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600"
                            >
                                Add Quote
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </section>
    );
}
