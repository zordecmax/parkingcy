import { useState, useEffect } from "react";

const cyprusCoords = {
    lat: 34.682332,
    lng: 33.0097412,
};

export const useChooseLocation = (location) => {
    const [chooseLocation, setChooseLocation] = useState(cyprusCoords);

    useEffect(() => {
        const initialChooseLocation = location ? null : cyprusCoords;

        setChooseLocation(initialChooseLocation);
    }, [location]);

    useEffect(() => {
        const coordinates = document
            .querySelector('meta[name="coordinates"]')
            ?.getAttribute("content");

        if (coordinates) {
            const coordinatesToObject = JSON.parse(coordinates);
            setChooseLocation({
                lat: parseFloat(coordinatesToObject.lat),
                lng: parseFloat(coordinatesToObject.lng),
            });
        }
    }, []);

    return { chooseLocation, setChooseLocation };
};
