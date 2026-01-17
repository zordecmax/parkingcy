import { Parking } from "./Parking";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import { ThemeProvider, createTheme } from "@mui/material";
import { useMemo, useState, createContext, useEffect } from "react";

export const ColorModeContext = createContext({ toggleColorMode: () => {} });

export const App = () => {
    const [mode, setMode] = useState("light");

    useEffect(() => {
        console.log(localStorage.getItem("theme_mode"));
        console.log(mode);
    }, [mode]);

    useEffect(() => {
        if (localStorage.getItem("theme_mode")) {
            setMode(localStorage.getItem("theme_mode"));
        }
    }, []);

    const colorMode = useMemo(
        () => ({
            toggleColorMode: () => {
                localStorage.setItem(
                    "theme_mode",
                    mode === "light" ? "dark" : "light"
                );
                setMode((prevMode) =>
                    prevMode === "light" ? "dark" : "light"
                );
            },
        }),
        [mode]
    );

    const theme = useMemo(
        () =>
            createTheme({
                palette: {
                    primary: {
                        main: "#0469b7",
                    },
                    mode,
                },
            }),
        [mode]
    );

    return (
        <BrowserRouter>
            <ColorModeContext.Provider value={colorMode}>
                <ThemeProvider theme={theme}>
                    <Routes>
                        <Route path="*" element={<Parking />} />
                    </Routes>
                </ThemeProvider>
            </ColorModeContext.Provider>
        </BrowserRouter>
    );
};
