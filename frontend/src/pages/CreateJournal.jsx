import { useNavigate } from "react-router-dom";
import JournalForm from "../components/JournalForm";
import { JournalsAPI } from "../services/journals";

export default function CreateJournal() {
    const navigate = useNavigate();

    async function handleSave(payload) {
        await JournalsAPI.create(payload);

        navigate("/journals", {
            state: {
                toast: {
                    type: "success",
                    message: "Journal saved successfully",
                },
            },
        });
    }

    return (
        <div className="max-w-3xl mx-auto space-y-6">
            <h2 className="text-xl font-semibold text-[#1F2933]">
                New Journal
            </h2>

            <JournalForm onSubmit={handleSave} />
        </div>
    );
}
