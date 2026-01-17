"use client";

import React, { useEffect, useRef, useState } from "react";
import { useMap } from "@vis.gl/react-google-maps";
import { MarkerClusterer } from "@googlemaps/markerclusterer";
import { Marker } from "./components/Marker";

export const Markers = ({
    points,
    handleOpenParkingDetails,
    changeCurrentDetails,
    getRouteToGoogleMap,
}) => {
    const map = useMap();
    const [markers, setMarkers] = useState([]);
    const [openInfoWindowId, setOpenInfoWindowId] = useState(null);
    const clusterer = useRef(null);

    useEffect(() => {
        if (!map) return;

        if (!clusterer.current) {
            clusterer.current = new MarkerClusterer({
                map: map,
            });
        }
    }, [map]);

    useEffect(() => {
        if (clusterer.current) {
            clusterer.current.clearMarkers();
            const newMarkers = points.map((point) => {
                return new google.maps.Marker({
                    position: { lat: point.lat, lng: point.lng },
                    title: point.name,
                    icon: {
                        url: 'data:image/svg+xml;charset=utf-8,<svg xmlns="http://www.w3.org/2000/svg" width="0" height="0"></svg>',
                    },
                });
            });
            clusterer.current.addMarkers(newMarkers);
        }
    }, [points]);

    const setMarkerRef = (marker, key) => {
        if (marker && markers[key]) return;
        if (!marker && !markers[key]) return;

        setMarkers((prev) => {
            if (marker) {
                return {
                    ...prev,
                    [key]: marker,
                };
            } else {
                const newMarkers = { ...prev };
                delete newMarkers[key];
                return newMarkers;
            }
        });
    };

    return (
        <>
            {points?.length &&
                points.map((point, index) => (
                    <Marker
                        key={index}
                        point={point}
                        setMarkerRef={setMarkerRef}
                        getRouteToGoogleMap={getRouteToGoogleMap}
                        handleOpenParkingDetails={handleOpenParkingDetails}
                        changeCurrentDetails={changeCurrentDetails}
                        openInfoWindowId={openInfoWindowId}
                        setOpenInfoWindowId={setOpenInfoWindowId}
                    />
                ))}
        </>
    );
};
