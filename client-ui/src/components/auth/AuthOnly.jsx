import { Navigate, Outlet, useLocation } from "react-router-dom";

const AuthOnly = ({ user }) => {
    // If authenticated, render the child routes; otherwise, redirect to login
    return user ? <Outlet /> : <Navigate to="/login" replace />;
};

export default AuthOnly;
