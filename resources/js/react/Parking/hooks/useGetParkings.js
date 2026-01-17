import { useState, useEffect, useCallback } from "react";
import { useNavigate } from "react-router-dom";
import debounce from "lodash/debounce";

export const useGetParkings = (queryParams = {}, location) => {
    const [parkings, setParkings] = useState([]);
    const [error, setError] = useState(null);
    const navigate = useNavigate();

    const fetchParkings = useCallback(
        debounce((params) => {
            const requestBody = {
                ...params,
                location:
                    location && location?.lat && location?.lng
                        ? {
                              lat: location.lat,
                              lng: location.lng,
                              radius: 10,
                          }
                        : null,
            };

            fetch("/api/parkings", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(requestBody),
            })
                .then((response) => {
                    if (!response.ok) throw new Error(response.statusText);
                    return response.json();
                })
                .then((data) => setParkings(data.data))
                .catch((error) => setError(error.message));
        }, 300), // 300ms задержка перед выполнением функции
        [location]
    );

    useEffect(() => {
        const params = new URLSearchParams();
        navigate(`?${params}`, { replace: true });

        fetchParkings(queryParams);

        // Отменяем debounce при размонтировании компонента
        return () => {
            fetchParkings.cancel();
        };
    }, [queryParams, fetchParkings, navigate]);

    return { parkings, setParkings, errorGetParkings: error };
};
