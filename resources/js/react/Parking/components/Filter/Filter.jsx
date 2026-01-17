import { useState, forwardRef, useEffect } from "react";
import FilterAltIcon from "@mui/icons-material/FilterAlt";
import CloseIcon from "@mui/icons-material/Close";
import BoltIcon from "@mui/icons-material/Bolt";
import {
    useTheme,
    useMediaQuery,
    Dialog,
    ListItemText,
    ListItemButton,
    AppBar,
    Toolbar,
    IconButton,
    Typography,
    Slide,
    ListItem,
    Switch,
    Button,
    Paper,
    Box,
    List,
    Divider,
    Alert,
    AlertTitle,
    Stack,
    ToggleButton,
    ToggleButtonGroup,
    InputLabel,
    OutlinedInput,
    MenuItem,
    FormControl,
    Select,
    Checkbox,
    Slider,
    Badge,
} from "@mui/material";
import { INITIAL_FILTER } from "../../helpers/initialFilter";
import { useLocation, useNavigate } from "react-router-dom";

const Transition = forwardRef(function Transition(props, ref) {
    return <Slide direction="up" ref={ref} {...props} />;
});

export const Filter = ({ filters, setFilters, parkingsCount }) => {
    const theme = useTheme();
    const isFullScreen = useMediaQuery(theme.breakpoints.down("sm"));
    const [open, setOpen] = useState(false);
    const [connectors, setConnectors] = useState([]);
    const [сhargingSpeed, setChargingSpeed] = useState([]);
    const navigate = useNavigate();
    const locationReactRouterDom = useLocation();

    useEffect(() => {
        fetch("/api/connector-types")
            .then((res) => res.json())
            .then((data) => setConnectors(data.data));
    }, []);

    useEffect(() => {
        const handlePopState = () => {
            if (open) {
                setOpen(false);
            }
        };

        window.addEventListener("popstate", handlePopState);

        return () => {
            window.removeEventListener("popstate", handlePopState);
        };
    }, [open]);

    const handleChargingSpeed = (event, newChargingSpeeds) => {
        setChargingSpeed(newChargingSpeeds);

        setFilters({
            ...filters,
            electric_charging_stations:
                newChargingSpeeds.length > 0
                    ? 1
                    : filters?.electric_charging_stations,
            charging_speed: newChargingSpeeds,
        });
    };

    const handleConnectorType = (event) => {
        setFilters({
            ...filters,
            electric_charging_stations: 1,
            connector_types: event.target.value,
        });
    };

    const getSelectedNames = (selectedIds) => {
        return selectedIds
            .map(
                (id) =>
                    connectors.find((connector) => connector.id === id)?.type
            )
            .filter((name) => name)
            .join(", ");
    };

    const handleClickOpen = () => {
        navigate(locationReactRouterDom.pathname + "#filter");

        setOpen(true);
    };

    const handleClose = () => {
        navigate(locationReactRouterDom.pathname);
        setOpen(false);
    };

    const handleReset = () => setFilters(INITIAL_FILTER);
    const handleApply = () => handleClose();

    const [checked, setChecked] = useState(true);

    const handleChange = (event, key) => {
        const value = event.target.checked ? 1 : 0;
        setFilters({
            ...filters,
            [key]: value,
        });
    };

    return (
        <>
            <Paper
                sx={{
                    position: "absolute",
                    bottom: "50px",
                    left: "50%",
                    transform: "translateX(-50%)",
                    py: 0,
                }}
            >
                <Box sx={{ display: "flex", justifyContent: "center" }}>
                    {/* <Badge badgeContent={4} color="success"> */}
                    <Button
                        variant="contained"
                        startIcon={<FilterAltIcon />}
                        onClick={handleClickOpen}
                    >
                        Filter
                    </Button>
                    {/* </Badge> */}
                </Box>
            </Paper>

            <Dialog
                fullScreen={isFullScreen}
                open={open}
                onClose={handleClose}
                TransitionComponent={Transition}
            >
                <AppBar sx={{ position: "relative" }}>
                    <Toolbar>
                        <IconButton
                            edge="start"
                            color="inherit"
                            onClick={handleClose}
                            aria-label="close"
                        >
                            <CloseIcon />
                        </IconButton>
                        <Typography
                            sx={{ ml: 2, flex: 1 }}
                            variant="h6"
                            component="div"
                        >
                            Filter
                        </Typography>
                    </Toolbar>
                </AppBar>
                <Alert
                    severity={parkingsCount > 0 ? "success" : "error"}
                    icon={false}
                    sx={{ display: "flex", justifyContent: "center", py: 1 }}
                >
                    {parkingsCount} surface parking lots
                </Alert>
                <List>
                    <ListItem>
                        <ListItemText primary="Show only handicap accessible spaces" />
                        <Switch
                            checked={!!filters?.handicap_accessible}
                            onChange={(e) =>
                                handleChange(e, "handicap_accessible")
                            }
                            inputProps={{ "aria-label": "controlled" }}
                        />
                    </ListItem>
                    <ListItem>
                        <ListItemText primary="Show only places that accept credit card payment" />
                        <Switch
                            checked={!!filters?.can_pay_by_card}
                            onChange={(e) => handleChange(e, "can_pay_by_card")}
                            inputProps={{ "aria-label": "controlled" }}
                        />
                    </ListItem>
                    <Divider />
                    <Typography variant="h6" textAlign={"center"} mt={1}>
                        Electric Vehicle
                    </Typography>
                    <ListItem>
                        <ListItemText primary="Show only places with an electric vehicle charger" />
                        <Switch
                            checked={!!filters?.electric_charging_stations}
                            onChange={(e) =>
                                handleChange(e, "electric_charging_stations")
                            }
                            inputProps={{ "aria-label": "controlled" }}
                        />
                    </ListItem>
                    <Divider />
                    <ListItem sx={{ justifyContent: "space-between" }}>
                        <Typography sx={{ mr: 1 }}>Charging speed</Typography>
                        <Stack spacing={4}>
                            <ToggleButtonGroup
                                value={сhargingSpeed}
                                onChange={handleChargingSpeed}
                                aria-label="сhargingSpeed"
                                sx={{ width: "100%" }}
                            >
                                <ToggleButton
                                    value="1"
                                    aria-label="1"
                                    color="primary"
                                >
                                    Slow
                                </ToggleButton>
                                <ToggleButton
                                    value="2"
                                    aria-label="2"
                                    color="primary"
                                >
                                    Medium
                                </ToggleButton>
                                <ToggleButton
                                    value="3"
                                    aria-label="3"
                                    color="primary"
                                >
                                    Fast
                                </ToggleButton>
                            </ToggleButtonGroup>
                        </Stack>
                    </ListItem>
                    <ListItem sx={{ justifyContent: "space-between" }}>
                        <Typography>Connector Type</Typography>

                        <FormControl sx={{ m: 1, width: 300 }}>
                            <InputLabel id="demo-multiple-checkbox-label">
                                Type
                            </InputLabel>
                            <Select
                                multiple
                                value={filters?.connector_types}
                                onChange={handleConnectorType}
                                input={<OutlinedInput label="Tag" />}
                                renderValue={(selected) =>
                                    getSelectedNames(selected)
                                }
                            >
                                {connectors.map((connector) => (
                                    <MenuItem
                                        key={connector.id}
                                        value={connector.id}
                                    >
                                        <Checkbox
                                            checked={filters?.connector_types?.includes(
                                                connector.id
                                            )}
                                        />
                                        <ListItemText
                                            primary={connector.type}
                                        />
                                    </MenuItem>
                                ))}
                            </Select>
                        </FormControl>
                    </ListItem>
                    <ListItem>
                        <Typography>Height of your vehicle</Typography>
                    </ListItem>
                    <ListItem>
                        <Box
                            sx={{
                                display: "flex",
                                alignItems: "center",
                                width: "100%",
                            }}
                        >
                            <Slider
                                defaultValue={1.6}
                                value={filters?.max_vehicle_height}
                                min={1.6}
                                step={0.1}
                                max={5.0}
                                aria-label="Default"
                                valueLabelDisplay="auto"
                                onChange={(e) =>
                                    setFilters({
                                        ...filters,
                                        max_vehicle_height: e.target.value,
                                    })
                                }
                            />
                            <Typography
                                variant="h5"
                                sx={{ minWidth: "90px;", ml: 2 }}
                            >
                                {filters?.max_vehicle_height} m
                            </Typography>
                        </Box>
                    </ListItem>
                    <ListItem sx={{ justifyContent: "center" }}>
                        <Button
                            variant="outlined"
                            onClick={handleReset}
                            sx={{
                                color:
                                    theme.palette.mode === "dark"
                                        ? "white"
                                        : "main.primary",
                                borderColor:
                                    theme.palette.mode === "dark"
                                        ? "white"
                                        : "main.primary",
                            }}
                        >
                            Clear
                        </Button>
                        <Button
                            variant="contained"
                            sx={{ ml: 1 }}
                            onClick={handleApply}
                        >
                            Apply
                        </Button>
                    </ListItem>
                </List>
            </Dialog>
        </>
    );
};
