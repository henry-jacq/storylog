const API_BASE = "http://127.0.0.1:8000";

async function request(url, options = {}) {
    const res = await fetch(`${API_BASE}${url}`, options);
    const json = await res.json();

    if (!json.status) {
        throw new Error(json.detail || "API Error");
    }

    return json.data;
}

export const JournalsAPI = {
    list: () => request("/journals/"),

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

};
