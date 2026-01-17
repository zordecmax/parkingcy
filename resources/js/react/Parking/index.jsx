import ReactDOM from "react-dom/client";
import { StrictMode } from "react";
import { Parking } from "./Parking";
import { Router, BrowserRouter, Routes, Route } from "react-router-dom";
import { ThemeProvider, createTheme } from "@mui/material";
import { orange } from "@mui/material/colors";
import { useMemo, useState, createContext } from "react";
import { App } from "./App";

// const ColorModeContext = React.createContext({ toggleColorMode: () => {} });

// const theme = createTheme({
//     palette: {
//         primary: {
//             main: "#0469b7",
//         },
//     },
// });

ReactDOM.createRoot(document.getElementById("parking")).render(
    // <StrictMode>
    <App />
    // </StrictMode>
);
