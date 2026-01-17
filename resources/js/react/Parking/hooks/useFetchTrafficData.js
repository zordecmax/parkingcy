import { useState, useCallback } from "react";
import debounce from "lodash/debounce";

export const useFetchTrafficData = () => {
    const [trafficDataMap, setTrafficDataMap] = useState({});
    const [isRefreshing, setIsRefreshing] = useState(false);

    const fetchTrafficDataForParkings = useCallback(
        debounce(async (parkingIds, forceRefresh = false) => {
            if (!parkingIds || parkingIds.length === 0) return;

            setIsRefreshing(true);

            try {
                // Fetch traffic data for all parkings in parallel
                const promises = parkingIds.map((id) =>
                    fetch(`/api/debug/parkings/${id}/google-traffic`)
                        .then((res) => res.json())
                        .then((data) => {
                            if (data?.ok && data?.pressure !== undefined) {
                                return { id, pressure: data.pressure, ...data };
                            }
                            return { id, pressure: null };
                        })
                        .catch((error) => {
                            console.error(`Error fetching traffic data for parking ${id}:`, error);
                            return { id, pressure: null };
                        })
                );

                const results = await Promise.all(promises);

                // Update traffic data map
                setTrafficDataMap((prev) => {
                    const newMap = forceRefresh ? {} : { ...prev };
                    results.forEach((result) => {
                        if (result.pressure !== null) {
                            newMap[result.id] = result.pressure;
                        }
                    });
                    return newMap;
                });
            } finally {
                setIsRefreshing(false);
            }
        }, 500), // Debounce to avoid too many requests
        []
    );

    return { trafficDataMap, fetchTrafficDataForParkings, isRefreshing };
};
