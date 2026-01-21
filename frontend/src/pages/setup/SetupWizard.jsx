import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { SettingsAPI } from "../../services/settings";

import WelcomeStep from "./steps/WelcomeStep";
import ProfileStep from "./steps/ProfileStep";
import SecurityStep from "./steps/SecurityStep";
import DoneStep from "./steps/DoneStep";

const steps = [
    WelcomeStep,
    ProfileStep,
    SecurityStep,
    DoneStep,
];

export default function SetupWizard() {
    const [step, setStep] = useState(0);
    const navigate = useNavigate();

    const [state, setState] = useState({
        name: "",
        email: "",
        appLockEnabled: false,
        appLockSecret: "",
        journalSecret: "",
    });

    function next(data = {}) {
        setState(prev => ({ ...prev, ...data }));
        setStep(s => s + 1);
    }

    async function finish() {
        await SettingsAPI.finishSetup({
            name: state.name || null,
            email: state.email || null,
            app_lock_password: state.appLockEnabled ? state.appLockSecret : null,
            journal_password: state.journalSecret || null,
        });

        navigate("/", { replace: true });
    }

    const Step = steps[step];

    return (
        <div className="min-h-screen bg-[#F8F9FA] flex items-center justify-center px-4">
            <div className="w-full max-w-md p-8 space-y-6 bg-white border rounded-xl">
                <Step
                    data={state}
                    onNext={next}
                    onFinish={finish}
                    step={step + 1}
                    total={steps.length}
                />
            </div>
        </div>
    );
}
