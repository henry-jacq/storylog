export const API_BASE = "http://127.0.0.1:8000";

export async function request(url, options = {}) {
    const res = await fetch(`${API_BASE}${url}`, options);
    const json = await res.json();

    if (!json.status) {
        throw new Error(json.detail || "API Error");
    }

    return json.data;
}