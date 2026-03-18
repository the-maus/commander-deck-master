import { Navigate, Outlet, useLocation } from "react-router-dom";

const GuestOnly = ({ user }) => {
    // If guest (not authenticated) render the child elements, otherwise redirect to main page
    return !user ? <Outlet /> : <Navigate to="/" replace />;
};

export default GuestOnly;
