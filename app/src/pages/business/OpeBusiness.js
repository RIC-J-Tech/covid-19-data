import React from 'react';
import { Route } from 'react-router';
import Card from "react-bootstrap/Card";
import {BehaviorList} from "../behavior/BehaviorList";
import {BehaviorPost} from "../../shared/components/behavior-post/BehaviorPost";
import CardMedia from '@material-ui/core/CardMedia';
import { makeStyles } from '@material-ui/core/styles';
import Box from '@material-ui/core/Box';
import {VotePost} from "../../shared/components/vote-post/VotePost";
import CardContent from '@material-ui/core/CardContent';
import Typography from '@material-ui/core/Typography';


const useStyles = makeStyles({
	root: {
		maxWidth: 345,
	},
	card: {
		position: 'relative',
		display: 'flex',
		marginBottom: 10
	},
	image: {
		minWidth: 200
	},
	content: {
		padding: 5,
		objectFit: 'cover'
	}

});
export const OpeBusiness = ({business,behaviors}) => {
	const classes = useStyles();



	return (

//this gives form to the recipes in the list on DOM
		<Route render={ ({history}) => (


			<>
				<Card className={classes.card}>

					<CardContent className={classes.content}>

						<Typography variant="body1">
							 			<BehaviorList behaviors={behaviors} />
						</Typography>
						<span>{business.voteCount} Votes</span>


					</CardContent>
				</Card>


			</>
		)}/>
	)
};
