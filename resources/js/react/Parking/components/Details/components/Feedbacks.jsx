import { List, ListItem, Typography, Box } from "@mui/material";
import { Feedback } from "./Feedback";
import PersonIcon from "@mui/icons-material/Person";
import { useEffect, useState } from "react";

export const Feedbacks = ({ feedbacks, setFeedbacks, parkingId }) => {
    console.log(feedbacks);

    useEffect(() => {
        fetch(`/api/reviews/${parkingId}`)
            .then((res) => res.json())
            .then((data) => {
                if (data?.code === 200) {
                    setFeedbacks(data.data);
                }
            });
    }, []);

    return (
        <>
            {feedbacks?.length ? (
                <List>
                    <ListItem>
                        <Box sx={{ width: "100%" }}>
                            <Typography variant="h6" mb={1}>
                                Feedbacks
                            </Typography>
                            <Box sx={{ width: "100%" }}>
                                {feedbacks?.map((item) => (
                                    <Feedback key={item.id} feedback={item} />
                                ))}
                            </Box>
                        </Box>
                    </ListItem>
                </List>
            ) : (
                ""
            )}
        </>
    );
};
