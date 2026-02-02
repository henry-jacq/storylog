import { Routes, Route } from "react-router-dom";
import Layout from "./Layout";

import Home from "../pages/Home";
import CreateJournal from "../pages/CreateJournal";
import BrowseJournals from "../pages/BrowseJournals";
import EditJournal from "../pages/EditJournal";
import ViewJournal from "../pages/ViewJournal";
import Settings from "../pages/Settings";
import Quotes from "../pages/Quotes";
import SetupWizard from "../pages/setup/SetupWizard";

export default function Router() {
    return (
        <Routes>
            <Route path="/setup" element={<SetupWizard />} />

            <Route element={<Layout />}>
                <Route path="/" element={<Home />} />
                <Route path="/journals/new" element={<CreateJournal />} />
                <Route path="/journals" element={<BrowseJournals />} />
                <Route path="/journals/:id" element={<ViewJournal />} />
                <Route path="/journals/:id/edit" element={<EditJournal />} />
                <Route path="/quotes" element={<Quotes />} />
                <Route path="/settings" element={<Settings />} />
            </Route>
        </Routes>
    );
}
