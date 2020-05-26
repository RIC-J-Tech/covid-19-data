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
				{/* <img height="160" width="190" src ={business.businessAvatar} alt=""/> */}
				<Card className={classes.card}>
					{/*<CardMedia*/}
					{/*	image={userImage}*/}
					{/*	title="Profile image"*/}
					{/*	className={classes.image}*/}
					{/*/>*/}
					<CardContent className={classes.content}>
						{/*<Typography variant="body2" color="textSecondary">*/}
						{/*	{dayjs(createdAt).fromNow()}*/}
						{/*</Typography>*/}
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

// <Card className="my-5 border border-dark alternate-bg ml-5 " >
//
//
// 	<Card.Body className="row my-3 px-5">
//
// 		<div className="col-4 pt-5 align-self-start " style={{width:25}}>
// 			<BehaviorPost behaviorBusinessId = {business.businessId}/>
// 		</div>
//
// 		<div style={{width: 40,heigh:200, order: -1}} className="col-8">
// 			<BehaviorList behaviors={behaviors} /> Total votes: {business.voteCount}
// 		</div>
//
// 	</Card.Body>
//
// </Card>