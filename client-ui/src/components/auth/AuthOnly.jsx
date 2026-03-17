import { Outlet, Navigate } from "react-router-dom";
import { useAuth } from "../../hooks/useAuth";

const AuthOnly = () => {
    const { authenticated } = useAuth(); // Check auth status

    // If authenticated, render the child routes; otherwise, redirect to login
    return authenticated() ? <Outlet /> : <Navigate to="/login" replace />;
};

export default AuthOnly;
