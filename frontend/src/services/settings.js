import { request } from "./api.js";

export const SettingsAPI = {
    get: () => request("/settings"),
    update: (payload) =>
        request("/settings", {
            method: "PATCH",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload),
        }),
};
