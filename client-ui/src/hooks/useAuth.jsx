import { useEffect, useState } from "react";

export const useAuth = () => {
    const [accessToken, setAccessToken] = useState(() => {
        return window.localStorage.getItem('accessToken');
    });

    useEffect(() => {
        window.localStorage.setItem("accessToken", accessToken);
    }, [accessToken]);

    const authenticated = () => {
        return accessToken !== null && accessToken !== 'null';
    }

    return {accessToken, setAccessToken, authenticated};
};
