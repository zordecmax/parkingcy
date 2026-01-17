import { useState, useEffect, useMemo } from "react";
import { Card, CardMedia, Chip, Rating, Stack, Switch } from "@mui/material";
import CloseIcon from "@mui/icons-material/Close";
import LocationOnIcon from "@mui/icons-material/LocationOn";
import PhoneIcon from "@mui/icons-material/Phone";
import HeightIcon from "@mui/icons-material/Height";
import PowerIcon from "@mui/icons-material/Power";
import AccessibleForwardIcon from "@mui/icons-material/AccessibleForward";
import PaymentIcon from "@mui/icons-material/Payment";
import PaymentsIcon from "@mui/icons-material/Payments";
import BottomNavigation from "@mui/material/BottomNavigation";
import BottomNavigationAction from "@mui/material/BottomNavigationAction";
import RestoreIcon from "@mui/icons-material/Restore";
import FavoriteIcon from "@mui/icons-material/Favorite";
import ThumbUpAltRoundedIcon from "@mui/icons-material/ThumbUpAltRounded";
import ThumbDownRoundedIcon from "@mui/icons-material/ThumbDownRounded";
import {
    Button,
    Dialog,
    List,
    Divider,
    AppBar,
    Toolbar,
    IconButton,
    Typography,
    Box,
    Container,
    Alert,
    useTheme,
    useMediaQuery,
    Paper,
} from "@mui/material";
import {
    Transition,
    Schedule,
    DetailsItem,
    RatingFeedback,
    Feedbacks,
} from "./components";
import { v4 as uuidv4 } from "uuid";

export const Details = ({
    isNear,
    details,
    openParkingDetails,
    handleOpenParkingDetails,
    getRouteToGoogleMap,
    // handleSpaceAvailable,
}) => {
    const theme = useTheme();
    const isFullScreen = useMediaQuery(theme.breakpoints.down("sm"));
    const [value, setValue] = useState(0);
    const [report, setReport] = useState(details?.report ?? null);
    const [counter, setCounter] = useState(parseInt(report?.message) ?? 0);
    const [reFetchReport, setReFetchReport] = useState(false);
    const [userUuid, setUserUuid] = useState(null);
    const [feedbacks, setFeedbacks] = useState([]);
    const [trafficData, setTrafficData] = useState(null);

    const BottomNavigationActionStyles = {
        "& .Mui-selected": {
            color: theme.palette.mode === "dark" ? "white" : "primary.main",
        },
        "& .MuiBottomNavigationAction-label": {
            color: theme.palette.mode === "dark" ? "white" : "primary.main",
        },
    };

    useEffect(() => {
        console.log();
        if (localStorage.getItem("userUuid")) {
            setUserUuid(localStorage.getItem("userUuid"));
        } else {
            localStorage.setItem("userUuid", uuidv4());
            setUserUuid(localStorage.getItem("userUuid"));
        }
    }, []);

    const fetchReports = () => {
        setReport(null);
        try {
            fetch(`/api/parkings/${details?.id}/reports`)
                .then((res) => res.json())
                .then((data) => {
                    if (data?.code === 200) {
                        setReport(data.data);
                    }
                });
        } catch (error) {
            console.error("Error fetching reports:", error);
        }
    };

    const handleSpaceAvailable = (isSpaceAvailable) => {
        if (isNear) {
            fetch("/api/parking-reports", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    user_uuid: userUuid,
                    is_space_available: isSpaceAvailable,
                    parking_id: details.id,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    setReport(data.data.report);
                })
                .catch((error) => {
                    console.error(error);
                });
        } else {
            setReport({
                is_space_available: 0,
                message:
                    "We cannot accept your report because you are far from the parking lot",
            });
        }
    };

    const active = details?.active ?? true;

    // Function to get availability status based on pressure
    const getAvailabilityStatus = (pressure) => {
        if (pressure > 0.75) {
            return { text: "Full", color: "#dc3545", severity: "error" };
        }
        if (pressure > 0.3) {
            return { text: "Moderate", color: "#fd7e14", severity: "warning" };
        }
        return { text: "Available", color: "#28a745", severity: "success" };
    };

    useEffect(() => {
        if (openParkingDetails && details?.id) {
            setReport(null);
            setTrafficData(null);
            fetchReports();

            const fetchTrafficData = () => {
                fetch(`/api/debug/parkings/${details.id}/google-traffic`)
                    .then((res) => res.json())
                    .then((data) => {
                        if (data?.ok && data?.pressure !== undefined) {
                            setTrafficData({
                                pressure: data.pressure,
                                ...data,
                            });
                        }
                    })
                    .catch((error) => {
                        console.error("Error fetching traffic data:", error);
                    });
            };

            fetchTrafficData();

            const reportIntervalId = setInterval(() => {
                // setCounter((prevCounter) => prevCounter + 1);
            }, 6000);

            const trafficIntervalId = setInterval(() => {
                fetchTrafficData();
            }, 5000);

            return () => {
                clearInterval(reportIntervalId);
                clearInterval(trafficIntervalId);
            };
        }
    }, [details?.id, openParkingDetails]);

    // Compute availability status from traffic data
    const availabilityStatus = useMemo(() => {
        if (trafficData?.pressure !== undefined) {
            return getAvailabilityStatus(trafficData.pressure);
        }
        return null;
    }, [trafficData?.pressure]);

    function splitString(string) {
        if (!string) return null;
        let match = string.match(/^(\d+)\s*(.*)/);

        if (match) {
            let firstNumber = match[1]; // The first number
            let restOfmatch = match[2]; // The rest of the string
            return [firstNumber, restOfString];
        } else {
            return null;
        }
    }

    return (
        <>
            {details && (
                <Dialog
                    fullScreen={isFullScreen}
                    open={openParkingDetails}
                    onClose={handleOpenParkingDetails}
                    TransitionComponent={Transition}
                >
                    <AppBar sx={{ position: "relative" }}>
                        <Toolbar>
                            <Box
                                sx={{
                                    display: "flex",
                                    alignItems: "center",
                                    justifyContent: "space-between",
                                    width: "100%",
                                }}
                            >
                                <Box>
                                    <Typography
                                        sx={{ flex: 1 }}
                                        variant="h6"
                                        component="div"
                                    >
                                        {details?.name}
                                    </Typography>
                                    {details?.total_spaces && (
                                        <Typography>
                                            Total spaces:{" "}
                                            {details?.total_spaces}
                                        </Typography>
                                    )}
                                    {details?.available_spaces && (
                                        <Typography>
                                            Available spaces:{" "}
                                            {details?.available_spaces}
                                        </Typography>
                                    )}
                                </Box>
                                <IconButton
                                    edge="start"
                                    color="inherit"
                                    onClick={handleOpenParkingDetails}
                                    aria-label="close"
                                >
                                    <CloseIcon />
                                </IconButton>
                            </Box>
                        </Toolbar>
                    </AppBar>
                    {trafficData && availabilityStatus && (
                        <Alert
                            severity={availabilityStatus.severity}
                            sx={{
                                backgroundColor: `${availabilityStatus.color}15`,
                                borderLeft: `4px solid ${availabilityStatus.color}`,
                            }}
                        >
                            <Typography variant="body1" sx={{ fontWeight: "bold" }}>
                                Parking Status: {availabilityStatus.text}
                            </Typography>
                        </Alert>
                    )}
                    {report && (
                        <Alert
                            severity={
                                report?.is_space_available
                                    ? "success"
                                    : "warning"
                            }
                        >
                            {report?.message}
                        </Alert>
                    )}
                    <List>
                        {details?.price_per_hour && (
                            <DetailsItem
                                icon={PaymentIcon}
                                primaryText={`${details.price_per_hour}$ price per hour`}
                            />
                        )}
                        {details?.price_per_day && (
                            <DetailsItem
                                icon={PaymentIcon}
                                primaryText={`${details.price_per_day}$ price per day`}
                            />
                        )}
                        {details?.address && (
                            <DetailsItem
                                icon={LocationOnIcon}
                                primaryText={details.address}
                            />
                        )}
                        {details?.phone && (
                            <>
                                <Divider />
                                <DetailsItem
                                    icon={PhoneIcon}
                                    primaryText={details.phone}
                                    link={`tel:${details.phone}`}
                                />
                            </>
                        )}
                    </List>
                    <Container>
                        <Button
                            variant="contained"
                            sx={{ width: "100%" }}
                            href={getRouteToGoogleMap(details)}
                        >
                            Get Directions
                        </Button>
                        {details?.description && (
                            <Box>
                                <Typography variant="h6" sx={{ mt: 2 }}>
                                    Description
                                </Typography>
                                <Typography>{details?.description}</Typography>
                            </Box>
                        )}
                        {details?.max_vehicle_height ||
                        details?.electric_charging_stations ||
                        details?.handicap_accessible ||
                        details?.can_by_card ? (
                            <Typography variant="h6" sx={{ mt: 2 }}>
                                Features
                            </Typography>
                        ) : null}
                    </Container>

                    <List>
                        {details?.max_vehicle_height && (
                            <DetailsItem
                                icon={HeightIcon}
                                primaryText={`Height restriction: ${details.max_vehicle_height} meters`}
                            />
                        )}
                        <Divider />
                        {details?.electric_charging_stations ? (
                            <DetailsItem
                                icon={PowerIcon}
                                primaryText="Electric vehicle charging stations"
                                secondaryText={
                                    details?.electric_charging_stations > 1
                                        ? `Number of stations: ${String(
                                              details?.electric_charging_stations
                                          )}`
                                        : ""
                                }
                            />
                        ) : null}

                        {details?.handicap_accessible ? (
                            <DetailsItem
                                icon={AccessibleForwardIcon}
                                primaryText="Handicap accessible spaces"
                                secondaryText={
                                    details?.handicap_accessible > 1
                                        ? `Number of spaces: ${String(
                                              details?.handicap_accessible
                                          )}`
                                        : ""
                                }
                            />
                        ) : null}

                        {details?.can_by_card && (
                            <DetailsItem
                                icon={PaymentIcon}
                                primaryText="Card payment available"
                            />
                        )}
                    </List>

                    {details?.schedule && (
                        <Schedule schedule={details?.schedule} />
                    )}
                    <RatingFeedback
                        parkingId={details?.id}
                        userUuid={userUuid}
                        feedbacks={feedbacks}
                        setFeedbacks={setFeedbacks}
                    />
                    <Feedbacks
                        parkingId={details?.id}
                        feedbacks={feedbacks}
                        setFeedbacks={setFeedbacks}
                    />
                    <BottomNavigation
                        showLabels
                        sx={{
                            py: 1,
                            position: "sticky",
                            zIndex: 9999,
                            bottom: 0,
                        }}
                        value={value}
                        onChange={(event, newValue) => {
                            if (newValue == 0) {
                                handleSpaceAvailable(true);
                            }

                            if (newValue == 1) {
                                handleSpaceAvailable(false);
                            }
                        }}
                    >
                        <BottomNavigationAction
                            label="Parking Available"
                            icon={<ThumbUpAltRoundedIcon color="success" />}
                            sx={BottomNavigationActionStyles}
                        />
                        <BottomNavigationAction
                            label="Parking Full"
                            icon={<ThumbDownRoundedIcon color="warning" />}
                            sx={BottomNavigationActionStyles}
                        />
                    </BottomNavigation>
                </Dialog>
            )}
        </>
    );
};
