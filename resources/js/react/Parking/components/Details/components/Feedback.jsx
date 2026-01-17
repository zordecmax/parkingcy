import { Box, Rating, Typography } from "@mui/material";

export const Feedback = ({ feedback }) => {
    return (
        <Box
            sx={{ mb: 1, width: "100%", borderBottom: "1px solid #ccc", pb: 1 }}
        >
            <Box sx={{ display: "flex", alignItems: "center" }}>
                <Rating name="read-only" value={feedback?.rating} readOnly />
                <Typography sx={{ ml: 1 }}>{feedback?.created_at}</Typography>
            </Box>
            <Typography sx={{ mt: 1 }}>{feedback?.review}</Typography>
        </Box>
    );
};
