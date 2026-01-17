import { useEffect, useState, useContext } from "react";
import { styled, useTheme } from "@mui/material/styles";
import {
    Box,
    Button,
    IconButton,
    Drawer,
    List,
    Divider,
    ListItem,
    ListItemButton,
    ListItemText,
    Typography,
    AppBar,
    Toolbar,
} from "@mui/material";
import ChevronLeftIcon from "@mui/icons-material/ChevronLeft";
import ChevronRightIcon from "@mui/icons-material/ChevronRight";
import MenuIcon from "@mui/icons-material/Menu";
import Brightness4Icon from "@mui/icons-material/Brightness4";
import Brightness7Icon from "@mui/icons-material/Brightness7";
import { Link } from "react-router-dom";
import { ColorModeContext } from "../../../Parking/App";

const DrawerHeader = styled("div")(({ theme }) => ({
    display: "flex",
    alignItems: "center",
    padding: theme.spacing(0, 1),
    // necessary for content to be below app bar
    ...theme.mixins.toolbar,
    justifyContent: "flex-end",
}));

const drawerWidth = 240;

export const Header = () => {
    const theme = useTheme();
    const [open, setOpen] = useState(false);
    const [airports, setAirports] = useState([]);
    const [cities, setCities] = useState([]);
    const colorMode = useContext(ColorModeContext);

    const handleDrawer = () => setOpen(!open);

    useEffect(() => {
        fetch("/api/airports")
            .then((response) => response.json())
            .then((data) => setAirports(data.data));

        fetch("/api/cities")
            .then((response) => response.json())
            .then((data) => setCities(data.data));
    }, []);

    return (
        <>
            <AppBar
                position="static"
                sx={{
                    background:
                        theme.palette.mode === "dark"
                            ? "primary.main"
                            : "white",
                }}
            >
                <Toolbar>
                    <Box
                        sx={{
                            display: "flex",
                            alignItems: "center",
                            justifyContent: "space-between",
                            width: "100%",
                            padding: "10px 0",
                        }}
                    >
                        <a href={"/"}>
                            <img
                                src="/images/logo.png"
                                alt="Cyprus parking"
                                style={{ height: "50px" }}
                            />
                        </a>
                        <Box>
                            <Button
                                variant="contained"
                                // sx={{
                                //     background: "primary.main",
                                //     color: "white",
                                // }}
                                disabled
                            >
                                Book
                            </Button>
                            <IconButton
                                sx={{
                                    ml: 1,
                                    background:
                                        theme.palette.mode === "dark"
                                            ? "primary.main"
                                            : "white",
                                }}
                                onClick={colorMode.toggleColorMode}
                            >
                                {theme.palette.mode === "dark" ? (
                                    <Brightness7Icon />
                                ) : (
                                    <Brightness4Icon />
                                )}
                            </IconButton>
                            <IconButton
                                aria-label="open drawer"
                                onClick={handleDrawer}
                                edge="start"
                                sx={{
                                    ml: 1,
                                    background:
                                        theme.palette.mode === "dark"
                                            ? "primary.main"
                                            : "white",
                                }}
                            >
                                <MenuIcon />
                            </IconButton>
                        </Box>
                    </Box>
                </Toolbar>
            </AppBar>
            <Drawer
                sx={{
                    width: drawerWidth,
                    flexShrink: 0,
                    "& .MuiDrawer-paper": {
                        width: drawerWidth,
                        boxSizing: "border-box",
                    },
                }}
                variant="persistent"
                anchor="right"
                open={open}
            >
                <DrawerHeader>
                    <IconButton onClick={handleDrawer}>
                        {theme.direction === "ltr" ? (
                            <ChevronLeftIcon />
                        ) : (
                            <ChevronRightIcon />
                        )}
                    </IconButton>
                </DrawerHeader>
                <Divider />
                <Typography variant="h5" sx={{ px: 1, pt: 1 }}>
                    Airports
                </Typography>
                <List sx={{ px: 1, pt: 0 }}>
                    {airports.map((airport) => (
                        <ListItem key={airport.id} disablePadding disabled>
                            <a
                                href={airport.link}
                                style={{
                                    color:
                                        theme.palette.mode === "dark"
                                            ? "white"
                                            : "primary.main",
                                }}
                            >
                                {airport.name}
                            </a>
                        </ListItem>
                    ))}
                </List>
                {/* <Divider /> */}
                <Typography variant="h5" sx={{ px: 1, pt: 1 }}>
                    Cities
                </Typography>
                <List sx={{ px: 1, pt: 0 }}>
                    {cities.map((city) => (
                        <ListItem key={city.id} disablePadding>
                            {/* <Link
                                to={city.link}
                                underline="none"
                                variant="body1"
                                style={{ cursor: "auto" }}
                                sx={{
                                    color:
                                        theme.palette.mode === "dark"
                                            ? "primary.main"
                                            : "white",
                                }}
                            > */}
                            {/* </Link> */}
                            <a
                                href={city.link}
                                style={{
                                    color:
                                        theme.palette.mode === "dark"
                                            ? "white"
                                            : "primary.main",
                                }}
                            >
                                {city.name}
                            </a>
                        </ListItem>
                    ))}
                </List>
            </Drawer>
        </>
    );
};
