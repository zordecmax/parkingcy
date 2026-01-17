import { useMap } from "@vis.gl/react-google-maps";

export const MyLocation = ({ currentLocation }) => {
    const map = useMap();

    const centerToCurrentLocation = () => {
        if (map && location) {
            map.setCenter(currentLocation);
        }
    };

    return (
        <button
            style={{ position: "absolute", bottom: 160, right: 10 }}
            onClick={centerToCurrentLocation}
            className="btn bg-white"
        >
            <i className="bi bi-crosshair"></i>
        </button>
    );
};
