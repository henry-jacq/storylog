import { API_BASE, request } from "./api.js";

export const JournalsAPI = {
    list: ({ page = 1, limit = 30, year, q } = {}) => {
        const params = new URLSearchParams({ page, limit });
        if (year) params.append("year", year);
        if (q) params.append("q", q);

        return request(`/journals?${params.toString()}`);
    },

    get: (id) => request(`/journals/${id}`),

    create: (payload) =>
        request("/journals/", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload),
        }),

    update: (id, payload) =>
        request(`/journals/${id}`, {
            method: "PATCH",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload),
        }),

    remove: (id) =>
        request(`/journals/${id}`, { method: "DELETE" }),

    importMd: async (file) => {
        const form = new FormData();
        form.append("file", file);

        const res = await fetch(`${API_BASE}/journals/import`, {
            method: "POST",
            body: form,
        });

        const json = await res.json();
        if (!json.status) throw new Error(json.detail);
        return json.data;
    },

    stats: () => request("/journals/stats"),
    insights: () => request("/journals/insights"),
};
