import { useState } from "react";
import { createPortal } from "react-dom";

export default function AddQuoteModal({ open, onClose, onSubmit }) {
    const [formData, setFormData] = useState({
        text: "",
        tags: ""
    });

    if (!open) return null;

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        if (!formData.text.trim()) {
            return;
        }
        onSubmit(formData);
    };

    return createPortal(
        <div className="fixed inset-0 z-[900] flex items-center justify-center p-4">
            <div
                className="absolute inset-0 bg-black/30"
                onClick={onClose}
            />

            <div className="relative z-10 w-full max-w-2xl p-6 bg-white shadow-xl rounded-xl max-h-[90vh] overflow-y-auto">
                <h2 className="text-xl font-semibold text-gray-900 mb-4">Add New Quote</h2>
                <form onSubmit={handleSubmit} className="space-y-4">
                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                            Quote Text *
                        </label>
                        <textarea
                            name="text"
                            value={formData.text}
                            onChange={handleChange}
                            className="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows={3}
                            placeholder="Enter the quote..."
                            required
                        />
                    </div>
                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-1">
                            Tags (comma separated)
                        </label>
                        <input
                            type="text"
                            name="tags"
                            value={formData.tags}
                            onChange={handleChange}
                            className="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="motivation, success, life..."
                        />
                    </div>
                    <div className="flex gap-3 mt-6">
                        <button
                            type="button"
                            onClick={onClose}
                            className="flex-1 px-4 py-2 font-medium text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-50"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            className="flex-1 px-4 py-2 font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600"
                        >
                            Add Quote
                        </button>
                    </div>
                </form>
            </div>
        </div>,
        document.body
    );
}
