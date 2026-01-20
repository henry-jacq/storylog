import { BrowserRouter, useNavigate } from "react-router-dom";
import { useEffect, useState } from "react";
import Router from "./Router";
import { SettingsAPI } from "../services/settings";

function AppGuard() {
    const navigate = useNavigate();
    const [checked, setChecked] = useState(false);

    useEffect(() => {
        SettingsAPI.get().then(settings => {
            if (!settings.is_initialized) {
                navigate("/setup", { replace: true });
            }
            setChecked(true);
        });
    }, []);

    if (!checked) return null;
    return <Router />;
}

export default function App() {
    return (
        <BrowserRouter>
            <AppGuard />
        </BrowserRouter>
    );
}
