"use client";
import { useEffect, useState, useRef, useCallback, useMemo } from "react";
import { APIProvider, Map, AdvancedMarker } from "@vis.gl/react-google-maps";
import { Markers } from "./components/Markers/Markers";
import { useCurrentLocation } from "./hooks/useCurrentLocation";
import { Details } from "./components/Details/Details";
import { MyLocation } from "./components/MyLocation/MyLocation";
import { useGetParkings } from "./hooks/useGetParkings";
import { Alert } from "@mui/material";
import { BottomMenu } from "./components/BottomMenu/BottomMenu";
import { Box } from "@mui/material";
import { Header } from "../common/components/Header/Header";
import { Filter } from "./components/Filter/Filter";
import { useSearchParams, useLocation, useNavigate } from "react-router-dom";
import haversine from "haversine-distance";
import { useChooseLocation } from "./hooks/useChooseLocation";
import { Button, IconButton, CircularProgress } from "@mui/material";
import RefreshIcon from "@mui/icons-material/Refresh";
import { INITIAL_FILTER } from "./helpers/initialFilter";
import { useTheme } from "@emotion/react";
import { useFetchTrafficData } from "./hooks/useFetchTrafficData";

const MAX_PARKINGS_TO_FETCH = 10;

export const Parking = () => {
    const GOOGLE_MAPS_API_KEY = window.config.apiKey;
    const { location, setLocation, errorCurrentLocation } =
        useCurrentLocation();
    const { chooseLocation, setChooseLocation } = useChooseLocation(location);
    const [openParkingDetails, setOpenParkingDetails] = useState(false);
    const [filters, setFilters] = useState(INITIAL_FILTER);

    const { parkings, errorGetParkings, setParkings } = useGetParkings(filters, location);
    const [details, setDetails] = useState(null);
    const [error, setError] = useState(null);
    const locationHook = useLocation();
    const [isNear, setIsNear] = useState(false);
    const redMarkerIcon = {
        url: "https://maps.google.com/mapfiles/ms/icons/red-dot.png", // URL to the red marker image
    };
    const [cameraProps, setCameraProps] = useState(null);
    const navigate = useNavigate();
    const locationReactRouterDom = useLocation();
    const theme = useTheme();
    const { trafficDataMap, fetchTrafficDataForParkings, isRefreshing } = useFetchTrafficData();

    const getBoundsFromCamera = useCallback((center, zoom) => {
        if (!center || zoom === undefined) return null;

        const scale = Math.pow(2, zoom);
        const worldWidth = 360;
        const worldHeight = 180;

        const degreesPerPixel = worldWidth / (256 * scale);

        const viewportWidthDegrees = degreesPerPixel * 800;
        const viewportHeightDegrees = degreesPerPixel * 600;

        const latAdjustment = Math.cos((center.lat * Math.PI) / 180);

        return {
            north: center.lat + viewportHeightDegrees / 2,
            south: center.lat - viewportHeightDegrees / 2,
            east: center.lng + viewportWidthDegrees / (2 * latAdjustment),
            west: center.lng - viewportWidthDegrees / (2 * latAdjustment),
        };
    }, []);

    const isPointInBounds = useCallback((point, bounds) => {
        if (!bounds) return false;
        return (
            point.lat >= bounds.south &&
            point.lat <= bounds.north &&
            point.lng >= bounds.west &&
            point.lng <= bounds.east
        );
    }, []);

    const calculateDistance = useCallback((point1, point2) => {
        const R = 6371; // Earth's radius in km
        const dLat = ((point2.lat - point1.lat) * Math.PI) / 180;
        const dLon = ((point2.lng - point1.lng) * Math.PI) / 180;
        const a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos((point1.lat * Math.PI) / 180) *
                Math.cos((point2.lat * Math.PI) / 180) *
                Math.sin(dLon / 2) *
                Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }, []);

    const handleCameraChange = useCallback((ev) => {
        const cameraDetail = ev.detail;
        setCameraProps(cameraDetail);

        if (cameraDetail?.center && cameraDetail?.zoom !== undefined && parkings.length > 0) {
            const bounds = getBoundsFromCamera(cameraDetail.center, cameraDetail.zoom);

            if (bounds) {
                const visibleParkings = parkings.filter((parking) =>
                    isPointInBounds({ lat: parking.lat, lng: parking.lng }, bounds)
                );

                const parkingsNeedingData = visibleParkings.filter(
                    (p) => !trafficDataMap[p.id]
                );

                let parkingsToFetch = parkingsNeedingData;

                if (parkingsNeedingData.length >= MAX_PARKINGS_TO_FETCH) {
                    parkingsToFetch = parkingsNeedingData
                        .map((parking) => ({
                            ...parking,
                            distance: calculateDistance(
                                cameraDetail.center,
                                { lat: parking.lat, lng: parking.lng }
                            ),
                        }))
                        .sort((a, b) => a.distance - b.distance)
                        .slice(0, MAX_PARKINGS_TO_FETCH)
                        .map(({ distance, ...parking }) => parking); // Remove distance property
                }

                const visibleParkingIds = parkingsToFetch.map((p) => p.id);

                if (visibleParkingIds.length > 0) {
                    fetchTrafficDataForParkings(visibleParkingIds);
                }
            }
        }
    }, [parkings, trafficDataMap, fetchTrafficDataForParkings, getBoundsFromCamera, isPointInBounds, calculateDistance]);

    useEffect(() => {
        if (cameraProps?.center && cameraProps?.zoom !== undefined && parkings.length > 0) {
            const bounds = getBoundsFromCamera(cameraProps.center, cameraProps.zoom);

            if (bounds) {
                const visibleParkings = parkings.filter((parking) =>
                    isPointInBounds({ lat: parking.lat, lng: parking.lng }, bounds)
                );

                const parkingsNeedingData = visibleParkings.filter(
                    (p) => !trafficDataMap[p.id]
                );

                let parkingsToFetch = parkingsNeedingData;

                if (parkingsNeedingData.length >= MAX_PARKINGS_TO_FETCH) {
                    parkingsToFetch = parkingsNeedingData
                        .map((parking) => ({
                            ...parking,
                            distance: calculateDistance(
                                cameraProps.center,
                                { lat: parking.lat, lng: parking.lng }
                            ),
                        }))
                        .sort((a, b) => a.distance - b.distance)
                        .slice(0, MAX_PARKINGS_TO_FETCH)
                        .map(({ distance, ...parking }) => parking); // Remove distance property
                }

                const visibleParkingIds = parkingsToFetch.map((p) => p.id);

                if (visibleParkingIds.length > 0) {
                    fetchTrafficDataForParkings(visibleParkingIds);
                }
            }
        }
    }, [parkings, cameraProps, trafficDataMap, fetchTrafficDataForParkings, getBoundsFromCamera, isPointInBounds, calculateDistance]);

    useEffect(() => {
        if (location && details) {
            const userCoords = { lat: location.lat, lng: location.lng };
            const parkingCoords = { lat: details.lat, lng: details.lng };
            const distance = haversine(userCoords, parkingCoords);

            if (distance < 1000) {
                //в радиусе 100 км
                setIsNear(true);
            } else {
                setIsNear(false);
            }
        }
    }, [location, details]);

    useEffect(() => {
        const searchParams = new URLSearchParams(locationHook.search);
        setFilters({
            ...filters,
            handicap_accessible: searchParams.get("handicap_accessible") || 0,
            can_pay_by_card: searchParams.get("can_pay_by_card") || 0,
            electric_charging_stations:
                searchParams.get("electric_charging_stations") || 0,
        });
    }, []);

    useEffect(() => {
        if (errorGetParkings || errorCurrentLocation) {
            setError(errorGetParkings || errorCurrentLocation);

            setTimeout(() => {
                setError(null);
            }, 3000);
        }
    }, [errorGetParkings, errorCurrentLocation]);

    useEffect(() => {
        const handlePopState = () => {
            if (openParkingDetails) {
                setOpenParkingDetails(false);
            }
        };

        window.addEventListener("popstate", handlePopState);

        return () => {
            window.removeEventListener("popstate", handlePopState);
        };
    }, [openParkingDetails]);

    const changeCurrentDetails = (id) => {
        setDetails(parkings.find((parking) => parking.id === id));
    };

    const handleOpenParkingDetails = () => {
        if (openParkingDetails) {
            navigate(locationReactRouterDom.pathname);
        } else {
            navigate(locationReactRouterDom.pathname + "#details");
        }
        setOpenParkingDetails(!openParkingDetails);
    };

    const getRouteToGoogleMap = (point) =>
        `https://www.google.com/maps/dir/?api=1&origin=${
            location?.lat ?? chooseLocation.lat
        },${location?.lng ?? chooseLocation.lng}&destination=${point.lat},${
            point.lng
        }`;

    const handleSearchHere = () => setChooseLocation(cameraProps?.center);

    const handleRefreshTrafficData = useCallback(() => {
        if (!cameraProps?.center || cameraProps?.zoom === undefined || parkings.length === 0) {
            return;
        }

        const bounds = getBoundsFromCamera(cameraProps.center, cameraProps.zoom);

        if (bounds) {
            const visibleParkings = parkings.filter((parking) =>
                isPointInBounds({ lat: parking.lat, lng: parking.lng }, bounds)
            );

            let parkingsToFetch = visibleParkings;

            if (visibleParkings.length >= MAX_PARKINGS_TO_FETCH) {
                parkingsToFetch = visibleParkings
                    .map((parking) => ({
                        ...parking,
                        distance: calculateDistance(
                            cameraProps.center,
                            { lat: parking.lat, lng: parking.lng }
                        ),
                    }))
                    .sort((a, b) => a.distance - b.distance)
                    .slice(0, MAX_PARKINGS_TO_FETCH)
                    .map(({ distance, ...parking }) => parking); // Remove distance property
            }

            const visibleParkingIds = parkingsToFetch.map((p) => p.id);

            if (visibleParkingIds.length > 0) {
                fetchTrafficDataForParkings(visibleParkingIds, true);
            }
        }
    }, [cameraProps, parkings, fetchTrafficDataForParkings, getBoundsFromCamera, isPointInBounds, calculateDistance]);

    const parkingsWithPressure = useMemo(() => {
        return parkings.map((parking) => ({
            ...parking,
            pressure: trafficDataMap[parking.id] ?? parking.pressure,
        }));
    }, [parkings, trafficDataMap]);


    return (
        <Box
            sx={{
                background: theme.palette.mode === "dark" ? "#121212" : "white",
            }}
        >
            <Details
                isNear={isNear}
                location={location}
                openParkingDetails={openParkingDetails}
                handleOpenParkingDetails={handleOpenParkingDetails}
                details={details}
                getRouteToGoogleMap={getRouteToGoogleMap}
            />
            <Box
                sx={{
                    position: "relative",
                    display: "flex",
                    flexDirection: "column",
                    height: "100%",
                    // height: "100lvh",
                }}
            >
                {/* // <div className="position-relative"> */}
                <Header />
                <Box
                    sx={{
                        flex: "1 1 auto",
                        position: "relative",
                        height: "95%",
                        background:
                            theme.palette.mode === "dark"
                                ? "primary.main"
                                : "white",
                    }}
                >
                    {error && <Alert severity="error">{error}</Alert>}

                    <Box>
                        <APIProvider apiKey={GOOGLE_MAPS_API_KEY}>
                            <div className="map__container">
                                <Map
                                    onCameraChanged={handleCameraChange}
                                    defaultCenter={chooseLocation ?? location}
                                    defaultZoom={18}
                                    gestureHandling={"greedy"}
                                    mapId={"e911fd9d709d3c9e"}
                                    fullscreenControl={false}
                                    streetViewControl={false}
                                    mapTypeControl={false}
                                    style={{
                                        height: "95%",
                                    }}
                                >
                                    <Box
                                        sx={{
                                            position: "absolute",
                                            top: 10,
                                            left: "50%",
                                            transform: "translateX(-50%)",
                                            display: "flex",
                                            gap: 1,
                                            zIndex: 1000,
                                        }}
                                    >
                                        <IconButton
                                            color="primary"
                                            onClick={handleRefreshTrafficData}
                                            disabled={isRefreshing || !cameraProps}
                                            sx={{
                                                bgcolor: "background.paper",
                                                "&:hover": {
                                                    bgcolor: "action.hover",
                                                },
                                                boxShadow: 2,
                                            }}
                                            title="Refresh traffic data for visible parkings"
                                        >
                                            {isRefreshing ? (
                                                <CircularProgress size={24} />
                                            ) : (
                                                <RefreshIcon />
                                            )}
                                        </IconButton>
                                    </Box>
                                    <AdvancedMarker position={location}>
                                        <span className="user-marker"></span>
                                    </AdvancedMarker>
                                    {chooseLocation && (
                                        <AdvancedMarker
                                            position={chooseLocation}
                                            icon={redMarkerIcon}
                                        ></AdvancedMarker>
                                    )}
                                    <Markers
                                        points={parkingsWithPressure}
                                        handleOpenParkingDetails={
                                            handleOpenParkingDetails
                                        }
                                        changeCurrentDetails={
                                            changeCurrentDetails
                                        }
                                        getRouteToGoogleMap={
                                            getRouteToGoogleMap
                                        }
                                    />
                                </Map>
                            </div>
                            {location && (
                                <MyLocation currentLocation={location} />
                            )}
                        </APIProvider>
                    </Box>
                </Box>
                {/* // </div> */}
                <Filter
                    filters={filters}
                    setFilters={setFilters}
                    parkingsCount={parkings?.length}
                />
            </Box>
        </Box>
    );
};
