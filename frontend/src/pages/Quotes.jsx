import { useState, useEffect } from "react";
import { QuotesAPI } from "../services/quotes";
import AddQuoteModal from "../components/AddQuoteModal";
import ConfirmDialog from "../components/ConfirmDialog";
import Loader from "../components/Loader";
import EmptyState from "../components/EmptyState";
import Toast from "../components/Toast";
import {
    ChatBubbleLeftRightIcon,
    HeartIcon,
    BookmarkIcon,
    TrashIcon,
    MagnifyingGlassIcon,
    PlusIcon
} from "@heroicons/react/24/outline";
import { HeartIcon as HeartSolidIcon, BookmarkIcon as BookmarkSolidIcon } from "@heroicons/react/24/solid";

export default function Quotes() {
    const [quotes, setQuotes] = useState([]);
    const [stats, setStats] = useState({ total_quotes: 0, liked_quotes: 0, saved_quotes: 0 });
    const [searchTerm, setSearchTerm] = useState("");
    const [showAddModal, setShowAddModal] = useState(false);
    const [confirmOpen, setConfirmOpen] = useState(false);
    const [quoteToDelete, setQuoteToDelete] = useState(null);
    const [loading, setLoading] = useState(true);
    const [toast, setToast] = useState(null);

    // Load initial data
    useEffect(() => {
        loadQuotes();
        loadStats();
    }, []);

    // Reload quotes when filters change
    useEffect(() => {
        loadQuotes();
    }, [searchTerm]);

    const loadQuotes = async () => {
        try {
            setLoading(true);
            const params = {};
            if (searchTerm) params.search = searchTerm;

            const data = await QuotesAPI.getQuotes(params);
            setQuotes(data || []);
        } catch (err) {
            console.error("Failed to load quotes:", err);
            setToast({
                type: "error",
                message: "Failed to load quotes. Please try again."
            });
        } finally {
            setLoading(false);
        }
    };

    const loadStats = async () => {
        try {
            const data = await QuotesAPI.getStats();
            setStats(data || { total_quotes: 0, liked_quotes: 0, saved_quotes: 0 });
        } catch (err) {
            console.error("Failed to load stats:", err);
        }
    };

    const toggleLike = async (id) => {
        try {
            const updatedQuote = await QuotesAPI.toggleLikeQuote(id);
            setQuotes(quotes.map(quote =>
                quote.id === id ? updatedQuote : quote
            ));
            loadStats();
        } catch (err) {
            console.error("Failed to toggle like:", err);
            setToast({
                type: "error",
                message: "Failed to update like status"
            });
        }
    };

    const toggleSave = async (id) => {
        try {
            const updatedQuote = await QuotesAPI.toggleSaveQuote(id);
            setQuotes(quotes.map(quote =>
                quote.id === id ? updatedQuote : quote
            ));
            loadStats();
        } catch (err) {
            console.error("Failed to toggle save:", err);
            setToast({
                type: "error",
                message: "Failed to update save status"
            });
        }
    };

    const handleAddQuote = async (formData) => {
        try {
            const newQuote = await QuotesAPI.createQuote({
                text: formData.text,
                tags: formData.tags ? formData.tags.split(",").map(tag => tag.trim()).filter(tag => tag) : [],
                is_liked: false,
                is_saved: false
            });

            setQuotes([newQuote, ...quotes]);
            loadStats();
            setShowAddModal(false);
            setToast({
                type: "success",
                message: "Quote added successfully"
            });
        } catch (err) {
            console.error("Failed to add quote:", err);
            setToast({
                type: "error",
                message: "Failed to add quote. Please try again."
            });
        }
    };

    const handleDeleteClick = (quote) => {
        setQuoteToDelete(quote);
        setConfirmOpen(true);
    };

    const handleConfirmDelete = async () => {
        if (!quoteToDelete) return;
        try {
            await QuotesAPI.deleteQuote(quoteToDelete.id);
            setQuotes(quotes.filter(q => q.id !== quoteToDelete.id));
            loadStats();
            setConfirmOpen(false);
            setQuoteToDelete(null);
            setToast({
                type: "success",
                message: "Quote deleted successfully"
            });
        } catch (err) {
            console.error("Failed to delete quote:", err);
            setToast({
                type: "error",
                message: "Failed to delete quote. Please try again."
            });
        }
    };

    // Loading state
    if (loading && quotes.length === 0) {
        return <Loader label="Loading quotes…" />;
    }

    // Empty state
    if (!loading && quotes.length === 0 && !searchTerm) {
        return (
            <>
                <EmptyState
                    title="No quotes yet"
                    description="Add inspiring quotes to motivate and guide your journaling journey."
                    actionLabel="Add Quote"
                    onAction={() => setShowAddModal(true)}
                />
                <AddQuoteModal
                    open={showAddModal}
                    onClose={() => setShowAddModal(false)}
                    onSubmit={handleAddQuote}
                />
                {toast && <Toast type={toast.type} message={toast.message} />}
            </>
        );
    }

    return (
        <>
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <h2 className="text-xl font-semibold text-[#1F2933]">
                        Quotes Collection
                    </h2>
                    <button
                        onClick={() => setShowAddModal(true)}
                        className="flex items-center gap-2 text-sm px-3 py-1.5 rounded-md bg-[#3B82F6] text-white hover:bg-blue-600 hover:cursor-pointer transition"
                    >
                        <PlusIcon className="w-4 h-4" />
                        Add Quote
                    </button>
                </div>

                {/* Search */}
                <div className="relative">
                    <MagnifyingGlassIcon className="absolute left-3 top-1/2 w-5 h-5 text-[#6B7280] -translate-y-1/2" />
                    <input
                        type="text"
                        placeholder="Search quotes or tags..."
                        value={searchTerm}
                        onChange={(e) => setSearchTerm(e.target.value)}
                        className="w-full pl-10 pr-4 py-2 text-sm border border-[#E5E7EB] rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                {/* Stats */}
                <div className="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div className="p-4 bg-white border border-[#E5E7EB] rounded-lg">
                        <div className="flex items-center justify-between">
                            <span className="text-sm text-[#6B7280]">Total Quotes</span>
                            <ChatBubbleLeftRightIcon className="w-5 h-5 text-[#6B7280]" />
                        </div>
                        <div className="mt-2 text-2xl font-semibold text-[#1F2933]">
                            {stats.total_quotes}
                        </div>
                    </div>
                    <div className="p-4 bg-white border border-[#E5E7EB] rounded-lg">
                        <div className="flex items-center justify-between">
                            <span className="text-sm text-[#6B7280]">Liked</span>
                            <HeartIcon className="w-5 h-5 text-[#6B7280]" />
                        </div>
                        <div className="mt-2 text-2xl font-semibold text-[#1F2933]">
                            {stats.liked_quotes}
                        </div>
                    </div>
                    <div className="p-4 bg-white border border-[#E5E7EB] rounded-lg">
                        <div className="flex items-center justify-between">
                            <span className="text-sm text-[#6B7280]">Saved</span>
                            <BookmarkIcon className="w-5 h-5 text-[#6B7280]" />
                        </div>
                        <div className="mt-2 text-2xl font-semibold text-[#1F2933]">
                            {stats.saved_quotes}
                        </div>
                    </div>
                </div>

                {/* Quotes List */}
                <div className="space-y-3">
                    {quotes.length === 0 ? (
                        <div className="text-center py-12">
                            <ChatBubbleLeftRightIcon className="w-12 h-12 text-[#E5E7EB] mx-auto mb-4" />
                            <p className="text-sm text-[#6B7280]">No quotes found matching your criteria.</p>
                        </div>
                    ) : (
                        quotes.map(quote => (
                            <div key={quote.id} className="p-4 bg-white border border-[#E5E7EB] rounded-lg">
                                <div className="flex items-start justify-between gap-4">
                                    <div className="flex-1 min-w-0">
                                        <blockquote className="text-[15px] text-[#1F2933] leading-relaxed">
                                            "{quote.text}"
                                        </blockquote>
                                        {quote.tags && quote.tags.length > 0 && (
                                            <div className="mt-2 flex flex-wrap gap-2">
                                                {quote.tags.map(tag => (
                                                    <span key={tag} className="text-xs text-[#6B7280]">
                                                        #{tag}
                                                    </span>
                                                ))}
                                            </div>
                                        )}
                                    </div>
                                    <div className="flex gap-1 shrink-0">
                                        <button
                                            onClick={() => toggleLike(quote.id)}
                                            className="p-2 transition rounded-md hover:bg-gray-50 hover:cursor-pointer"
                                            title={quote.is_liked ? "Unlike" : "Like"}
                                        >
                                            {quote.is_liked ? (
                                                <HeartSolidIcon className="w-5 h-5 text-red-500" />
                                            ) : (
                                                <HeartIcon className="w-5 h-5 text-[#6B7280]" />
                                            )}
                                        </button>
                                        <button
                                            onClick={() => toggleSave(quote.id)}
                                            className="p-2 transition rounded-md hover:bg-gray-50 hover:cursor-pointer"
                                            title={quote.is_saved ? "Unsave" : "Save"}
                                        >
                                            {quote.is_saved ? (
                                                <BookmarkSolidIcon className="w-5 h-5 text-[#3B82F6]" />
                                            ) : (
                                                <BookmarkIcon className="w-5 h-5 text-[#6B7280]" />
                                            )}
                                        </button>
                                        <button
                                            onClick={() => handleDeleteClick(quote)}
                                            className="p-2 transition rounded-md hover:bg-gray-50 hover:cursor-pointer"
                                            title="Delete quote"
                                        >
                                            <TrashIcon className="w-5 h-5 text-[#6B7280]" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        ))
                    )}
                </div>
            </div>

            {/* Add Quote Modal */}
            <AddQuoteModal
                open={showAddModal}
                onClose={() => setShowAddModal(false)}
                onSubmit={handleAddQuote}
            />

            {/* Confirm Delete */}
            <ConfirmDialog
                open={confirmOpen}
                title="Delete quote?"
                message={quoteToDelete ? `This will permanently delete the quote.\n\n"${quoteToDelete.text.substring(0, 80)}${quoteToDelete.text.length > 80 ? '...' : ''}"` : "This quote will be permanently deleted."}
                confirmText="Delete"
                onCancel={() => {
                    setConfirmOpen(false);
                    setQuoteToDelete(null);
                }}
                onConfirm={handleConfirmDelete}
            />

            {/* Toast */}
            {toast && <Toast type={toast.type} message={toast.message} />}
        </>
    );
}
