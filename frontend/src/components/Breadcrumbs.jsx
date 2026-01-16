import { Link, useLocation } from "react-router-dom";
import { HomeIcon , ChevronRightIcon } from "@heroicons/react/24/outline";

export default function Breadcrumbs() {
    const { pathname } = useLocation();
    const parts = pathname.split("/").filter(Boolean);

    return (
        <nav className="flex items-center text-sm text-[#6B7280]">

            <Link to="/" className="flex items-center hover:underline">
                Home
            </Link>

            {parts.map((part, i) => {
                const to = "/" + parts.slice(0, i + 1).join("/");

                return (
                    <span key={to} className="flex items-center">
                        <ChevronRightIcon className="mx-2 mt-0.5 h-3 w-3 text-[#9CA3AF]" />
                        <Link to={to} className="capitalize hover:underline">
                            {part.replace("-", " ")}
                        </Link>
                    </span>
                );
            })}
        </nav>
    );
}
