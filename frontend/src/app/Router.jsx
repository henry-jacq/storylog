import { Routes, Route } from "react-router-dom";
import Layout from "./Layout";

import Home from "../pages/Home";
import CreateJournal from "../pages/CreateJournal";
import BrowseJournals from "../pages/BrowseJournals";
import ViewJournal from "../pages/ViewJournal";
import Settings from "../pages/Settings";

export default function Router() {
    return (
        <Routes>
            <Route element={<Layout />}>
                <Route path="/" element={<Home />} />
                <Route path="/journals/new" element={<CreateJournal />} />
                <Route path="/journals" element={<BrowseJournals />} />
                <Route path="/journals/:id" element={<ViewJournal />} />
                <Route path="/settings" element={<Settings />} />
            </Route>
        </Routes>
    );
}
