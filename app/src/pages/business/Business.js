import React from "react";
import { makeStyles } from "@material-ui/core/styles";
import clsx from "clsx";
import Card from "@material-ui/core/Card";
import CardHeader from "@material-ui/core/CardHeader";
import CardMedia from "@material-ui/core/CardMedia";
import CardContent from "@material-ui/core/CardContent";
import Collapse from "@material-ui/core/Collapse";
import IconButton from "@material-ui/core/IconButton";
import Typography from "@material-ui/core/Typography";
import ExpandMoreIcon from "@material-ui/icons/ExpandMore";

import { BehaviorList } from "../behavior/BehaviorList";
import { BehaviorPost } from "../../shared/components/behavior-post/BehaviorPost";
import { Route } from "react-router";
import { Grid } from "@material-ui/core/Grid";
import grey from "@material-ui/core/colors/grey";

const primary800 = grey["800"];

const styles = (theme) => ({
	card: {
		backgroundColor: theme.palette.background.paper,
		color: theme.palette.primary.contrastText,
	},
});

const useStyles = makeStyles((theme) => ({
	root: {
		maxWidth: 500,
	},
	card: {
		backgroundColor: theme.palette.background.paper,
		color: theme.palette.primary.contrastText,
	},
	media: {
		height: 0,
		paddingTop: "56.25%", // 16:9
	},
	expand: {
		transform: "rotate(0deg)",
		marginLeft: "auto",
		transition: theme.transitions.create("transform", {
			duration: theme.transitions.duration.shortest,
		}),
	},
	expandOpen: {
		transform: "rotate(180deg)",
	},
}));

export default function RussBusiness({ business, behaviors }) {
	const classes = useStyles();
	const [expanded, setExpanded] = React.useState(false);

	const handleExpandClick = () => {
		setExpanded(!expanded);
	};

	return (

		<Card className={classes.root}>
			<CardHeader title={business.businessName} subheader="" />
			<CardMedia
				className={classes.media}
				image={business.businessAvatar}
				title="Yelp Business Image"
			/>
			<CardContent>
				<Typography variant="body2" color="textSecondary" component="p">
					<a href={business.businessUrl}>Yelp Business URL</a>
				</Typography>
			</CardContent>
			<IconButton
				className={clsx(classes.expand, {
					[classes.expandOpen]: expanded,
				})}
				onClick={handleExpandClick}
				aria-expanded={expanded}
				aria-label="show more"
			>
				<ExpandMoreIcon />
			</IconButton>
			<Collapse in={expanded} timeout="auto" unmountOnExit>
				<CardContent>
					<Typography paragraph>Behaviors:</Typography>
					<Typography paragraph>

						<div
							style={{ width: 400, height: 500, order: -1 }}
							className="col-8"
						>
							<BehaviorList behaviors={behaviors} />
						</div>

						<div className="col-4 pt-5 align-self-start " style={{ width: 25 }}>
							<BehaviorPost behaviorBusinessId={business.businessId} />
						</div>
					</Typography>
				</CardContent>
			</Collapse>
		</Card>

	);
}
