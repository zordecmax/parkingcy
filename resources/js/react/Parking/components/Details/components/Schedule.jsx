import { ListItemText, List, Typography, Box, ListItem } from "@mui/material";
import { isFullTime } from "../../../helpers/isFulltime";
import { days } from "../../../helpers/days";

export const Schedule = ({ schedule }) => {
    return (
        <List>
            <ListItem>
                <Box
                    sx={{
                        display: "flex",
                        flexDirection: "column",
                        width: "100%",
                    }}
                >
                    <Typography variant="h6">Working Hours</Typography>
                    <Box
                        sx={{
                            display: "flex",
                            alignItems: "center",
                            justifyContent: "space-between",
                            width: "100%",
                        }}
                    >
                        {isFullTime(schedule) ? (
                            <ListItemText primary="Full day" />
                        ) : (
                            <Box width={"100%"}>
                                {days?.map((day) => (
                                    <Box
                                        sx={{
                                            display: "flex",
                                            alignItems: "center",
                                            justifyContent: "space-between",
                                            width: "100%",
                                        }}
                                        key={day.value}
                                    >
                                        <ListItemText primary={day.label} />
                                        <ListItemText
                                            primary={`${
                                                schedule[
                                                    `${day.value}_time_start`
                                                ] ?? ""
                                            } - ${
                                                schedule[
                                                    `${day.value}_time_end`
                                                ] ?? ""
                                            }`}
                                            sx={{
                                                textAlign: "right",
                                            }}
                                            secondary={
                                                schedule[
                                                    `${day.value}_break_start`
                                                ] &&
                                                schedule[
                                                    `${day.value}_break_end`
                                                ]
                                                    ? `Lunch: ${
                                                          schedule[
                                                              `${day.value}_break_start`
                                                          ]
                                                      } - ${
                                                          schedule[
                                                              `${day.value}_break_end`
                                                          ]
                                                      }`
                                                    : null
                                            }
                                        />
                                    </Box>
                                ))}
                            </Box>
                        )}
                    </Box>
                </Box>
            </ListItem>
        </List>
    );
};
