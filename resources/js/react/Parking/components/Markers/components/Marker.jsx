"use client";

import { useCallback, useMemo } from "react";
import { AdvancedMarker } from "@vis.gl/react-google-maps";

const getMarkerColorClass = (value) => {
    if (value > 0.75) return 'parking__marker--red';
    if (value <= 0.75 && value > 0.3)   return 'parking__marker--orange';
    return 'parking__marker--green';
};

export const Marker = ({
    point,
    handleOpenParkingDetails,
    changeCurrentDetails,
}) => {
    const markerColorClass = useMemo(() => {
        return getMarkerColorClass(point.pressure);
    }, [point.pressure]);

    const handleMarkerClick = useCallback(() => {
        changeCurrentDetails(point.id);
        handleOpenParkingDetails();
    }, [point.id, changeCurrentDetails, handleOpenParkingDetails]);

    return (
        <AdvancedMarker
            position={{
                lat: point.lat,
                lng: point.lng,
            }}
            key={point.name}
            onClick={handleMarkerClick}
        >
            <div className={`parking__marker ${markerColorClass}`}>
                <span>
                    {(point?.price_per_hour || point?.price_per_day) ??
                        "P"}
                </span>
            </div>
        </AdvancedMarker>
    );
};
