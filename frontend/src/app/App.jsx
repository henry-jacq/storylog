import { BrowserRouter, useNavigate } from "react-router-dom";
import { useEffect, useState } from "react";
import Router from "./Router";
import { SettingsAPI } from "../services/settings";
import AppLock from "../pages/AppLock";

function AppGuard() {
    const navigate = useNavigate();

    const [checked, setChecked] = useState(false);
    const [locked, setLocked] = useState(false);

    useEffect(() => {
        let alive = true;

        (async () => {
            try {
                const data = await SettingsAPI.getPublic();
                if (!alive) return;

                if (!data.is_initialized) {
                    setChecked(true);
                    navigate("/setup", { replace: true });
                    return;
                }

                setLocked(data.app_lock_enabled);
                setChecked(true);
            } catch (e) {
                console.error("Settings load failed", e);
                setChecked(true);
            }
        })();

        return () => {
            alive = false;
        };
    }, [navigate]);

    if (!checked) return null;

    if (locked) {
        return <AppLock onUnlock={() => setLocked(false)} />;
    }

    return <Router />;
}

export default function App() {
    return (
        <BrowserRouter>
            <AppGuard />
        </BrowserRouter>
    );
}
