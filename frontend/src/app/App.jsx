import { BrowserRouter, useNavigate } from "react-router-dom";
import { useEffect, useState } from "react";
import Router from "./Router";
import { SettingsAPI } from "../services/settings";
import AppLock from "../pages/AppLock";

function AppGuard() {
    const navigate = useNavigate();

    const [checked, setChecked] = useState(false);
    const [settings, setSettings] = useState(null);
    const [unlocked, setUnlocked] = useState(false);

    useEffect(() => {
        SettingsAPI.get().then(data => {
            setSettings(data);

            // Setup not completed → force wizard
            if (!data.is_initialized) {
                navigate("/setup", { replace: true });
                return;
            }

            // No app lock → auto unlock
            if (!data.app_lock_secret) {
                setUnlocked(true);
            }

            setChecked(true);
        });
    }, []);

    // Still loading settings
    if (!checked) return null;

    // App lock enabled but not unlocked yet
    if (settings?.app_lock_secret && !unlocked) {
        return (
            <AppLock
                secret={settings.app_lock_secret}
                onUnlock={() => setUnlocked(true)}
            />
        );
    }

    // App unlocked -> normal routing
    return <Router />;
}

export default function App() {
    return (
        <BrowserRouter>
            <AppGuard />
        </BrowserRouter>
    );
}
