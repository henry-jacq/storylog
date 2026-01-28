import { request } from "./api.js";

export const SettingsAPI = {
    // public, non-sensitive
    getPublic: () => request("/settings/public"),

    // get authentication status
    getAuthStatus: () => request("/settings/auth-status"),

    // setup wizard
    finishSetup: (payload) =>
        request("/settings/setup", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload),
        }),

    // app unlock (simplified - journal password auto-derived)
    unlock: (appLockPassword) =>
        request("/settings/unlock", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ password: appLockPassword }),
        }),

    // change app lock password with re-encryption
    changePassword: (oldPassword, newPassword) =>
        request("/settings/change-password", {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ 
                old_password: oldPassword,
                new_password: newPassword 
            }),
        }),
};
