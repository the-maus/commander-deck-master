import { Outlet, Navigate } from "react-router-dom";
import { useAuth } from "../../hooks/useAuth";

const GuestOnly = () => {
    const { authenticated } = useAuth(); // Check auth status

    // If guest (not authenticated), render the child routes; otherwise, redirect to main page
    return !authenticated() ? <Outlet /> : <Navigate to="/" replace />;
};

export default GuestOnly;
