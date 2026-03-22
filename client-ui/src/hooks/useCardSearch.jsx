import { useState, useCallback, useRef, useEffect } from 'react';
import api from '../services/api';

export const useCardSearch = () => {
	const [loading, setLoading] = useState(false);
    const [options, setOptions] = useState([]); 

	// deal with memory leak
	const [canceled, setCanceled] = useState(false);

    async function search(query) {
        console.log(query)
        if (canceled) return;

        setLoading(true);

        try {
            const response = await api.get("/cards/autocomplete", {
                params: { q: query },
            });
            console.log(response);
            setOptions(response.data.data);

            setLoading(false);
        } catch (error) {
            console.log(error);

            setLoading(false);
        }
    }

	// avoid memory leak
	useEffect(() => {
		setCanceled(false);
		return () => setCanceled(true);
	}, []);

	return { options, search, loading };
};