import { request } from "./api.js";

export const SettingsAPI = {
    // public, non-sensitive
    getPublic: () => request("/settings/public"),

    // setup wizard
    finishSetup: (payload) =>
        request("/settings/setup", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload),
        }),

    // app unlock
    unlock: (password) =>
        request("/settings/unlock", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ password }),
        }),
};
