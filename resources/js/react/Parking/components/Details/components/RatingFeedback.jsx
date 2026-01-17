import React, { useState } from "react";
import {
    Box,
    Button,
    TextField,
    Typography,
    Rating,
    List,
    ListItem,
} from "@mui/material";

export const RatingFeedback = ({
    parkingId,
    userUuid,
    feedbacks,
    setFeedbacks,
}) => {
    const [rating, setRating] = useState(null);
    const [feedback, setFeedback] = useState("");
    const [error, setError] = useState("");
    const [submitted, setSubmitted] = useState(false);

    const handleRatingChange = (event, newRating) => {
        setRating(newRating);
    };

    const handleFeedbackChange = (event) => {
        setFeedback(event.target.value);
    };

    const handleSubmit = () => {
        if (rating === null && feedback.trim() === "") {
            setError("Please provide a rating or feedback.");
            return;
        }
        setError("");

        console.log(userUuid);

        fetch(`/api/reviews/${parkingId}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                rating,
                feedback,
                user_uuid: userUuid,
            }),
        })
            .then((response) => {
                if (!response.ok) {
                    return response.json().then((data) => {
                        throw new Error(
                            data.message || "Failed to submit review."
                        );
                    });
                }
                return response.json();
            })
            .then((data) => {
                setFeedbacks([...feedbacks, data?.data]);
                setSubmitted(true);
                setRating(null);
                setFeedback("");

                setTimeout(() => {
                    setSubmitted(false);
                }, 2000);
            })
            .catch((error) => {
                setError(error.message);
            });
    };

    return (
        <List>
            <ListItem>
                <Box sx={{ width: "100%" }}>
                    <Typography variant="h6">Leave a Review</Typography>
                    <Rating
                        name="rating"
                        value={rating}
                        onChange={handleRatingChange}
                    />
                    {submitted && (
                        <Typography
                            variant="body1"
                            color="warning"
                            sx={{ mt: 1 }}
                        >
                            Thank you for your feedback!
                        </Typography>
                    )}
                    <TextField
                        label="Your Feedback"
                        multiline
                        rows={4}
                        value={feedback}
                        onChange={handleFeedbackChange}
                        variant="outlined"
                        fullWidth
                        margin="normal"
                        sx={{ width: "100%", mt: 1 }}
                    />
                    {error && (
                        <Typography
                            color="error"
                            variant="body2"
                            sx={{ mb: 1, display: "block" }}
                        >
                            {error}
                        </Typography>
                    )}
                    <Button
                        variant="contained"
                        color="primary"
                        onClick={handleSubmit}
                    >
                        Submit
                    </Button>
                </Box>
            </ListItem>
        </List>
    );
};
