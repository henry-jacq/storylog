import { Link, useLocation } from "react-router-dom";

export default function Breadcrumbs() {
    const { pathname } = useLocation();
    const parts = pathname.split("/").filter(Boolean);

    return (
        <nav className="text-sm text-[#6B7280]">
            <Link to="/" className="hover:underline">Home</Link>

            {parts.map((part, i) => {
                const to = "/" + parts.slice(0, i + 1).join("/");
                return (
                    <span key={to}>
                        {" / "}
                        <Link to={to} className="capitalize hover:underline">
                            {part.replace("-", " ")}
                        </Link>
                    </span>
                );
            })}
        </nav>
    );
}
