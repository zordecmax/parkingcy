import * as React from "react";
import { ListItemText, IconButton, ListItem, Link } from "@mui/material";

export const DetailsItem = ({
    icon: Icon,
    primaryText,
    secondaryText = "",
    link,
}) => {
    return (
        <ListItem>
            <IconButton>
                <Icon />
            </IconButton>
            {link ? (
                <Link href={link} underline="none">
                    {primaryText}
                </Link>
            ) : (
                <ListItemText primary={primaryText} secondary={secondaryText} />
            )}
        </ListItem>
    );
};
