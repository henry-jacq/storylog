import { Outlet } from "react-router-dom";
import Breadcrumbs from "../components/Breadcrumbs";

export default function Layout() {
    return (
        <div className="min-h-screen bg-[#F8F9FA]">
            <main className="max-w-5xl px-6 py-10 mx-auto space-y-6">
                <Breadcrumbs />
                <Outlet />
            </main>
        </div>
    );
}
