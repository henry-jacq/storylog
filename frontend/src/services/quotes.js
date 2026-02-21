import { api } from "./api";

class QuotesAPI {
    static async getQuotes(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        const result = await api.get(`/quotes?${queryString}`);
        return result;
    }

    static async getQuote(id) {
        const result = await api.get(`/quotes/${id}`);
        return result;
    }

    static async createQuote(quoteData) {
        const result = await api.post("/quotes", quoteData);
        return result;
    }

    static async updateQuote(id, quoteData) {
        const result = await api.patch(`/quotes/${id}`, quoteData);
        return result;
    }

    static async deleteQuote(id) {
        const result = await api.delete(`/quotes/${id}`);
        return result;
    }

    static async toggleLikeQuote(id) {
        const result = await api.post(`/quotes/${id}/like`);
        return result;
    }

    static async toggleSaveQuote(id) {
        const result = await api.post(`/quotes/${id}/save`);
        return result;
    }

    static async getStats() {
        const result = await api.get("/quotes/stats");
        return result;
    }
}

export { QuotesAPI };
