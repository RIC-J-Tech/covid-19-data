import React from 'react';
import { Route } from 'react-router';
import Card from "react-bootstrap/Card";
import {BehaviorList} from "../behavior/BehaviorList";
import {BehaviorPost} from "../../shared/components/behavior-post/BehaviorPost";
import CardMedia from '@material-ui/core/CardMedia';
import { makeStyles } from '@material-ui/core/styles';
import Box from '@material-ui/core/Box';
import Grid from "@material-ui/core/Grid";
import Typography from "@material-ui/core/Typography";
import Button from "@material-ui/core/Button";
import CardActions from "@material-ui/core/CardActions";
import CardContent from "@material-ui/core/CardContent";
import CardActionArea from "@material-ui/core/CardActionArea";


// import logo from "./../images/recipe-placeholder.jpg";


const useStyles = makeStyles({
    root: {
      maxWidth: 345,
		 marginLeft:50
    },	card: {
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
export const TestBusiness = ({business,behaviors, votes}) => {
    const classes = useStyles();



	return (

//this gives form to the recipes in the list on DOM
		<Route render={ ({history}) => (
			<>
				<div className="mt-3 justify-content-center align-self-center">
					<h2 >What behaviors are you witnessing? </h2>
				</div>

		<div className="row container">

			<div className="col-7 col-xs-12" >

				<Card className="mb-3 border border-dark alternate-bg ml-5 p-3 " >
					<div className="mr-5">
						<a className="ml-5 p-2 align-self-center" href={business.businessUrl}>
							<Card.Title className="ml-5 align-self-center">{business.businessName}</Card.Title></a>
							<div className="col-5 col-md-5"><CardMedia className="align-self-center">
								<img height="250" width="350" src ={business.businessAvatar} alt="business photo"/>
								</CardMedia></div>
					</div>

					</Card>

			</div>

			<div className="col-5 col-xs-12">
				<Card className={classes.card}>
					<CardContent className={classes.content}>
						<Typography variant="body1">
							<BehaviorList behaviors={behaviors} />
						</Typography>
						<BehaviorPost behaviorBusinessId = {business.businessId}/>
						<span>{business.voteCount} Votes</span>
					</CardContent>
				</Card>
			</div>

		</div>
			</>
		)}/>
	)
};


// <Card className="my-5 border border-dark alternate-bg ml-5 p-5" >
//
// 	<div className="container">
// 		<a className="ml-5 p-2 align-self-center" href={business.businessUrl}>
// 			<Card.Title className="ml-5 align-self-center">{business.businessName}</Card.Title></a>
// 		<div className="col-5 col-md-5">
//
// 			<CardMedia className="align-self-center">
// 				<img height="250" width="350" src ={business.businessAvatar} alt="business photo"/>
// 			</CardMedia>
// 		</div>
// 	</div>
//
// </Card>
