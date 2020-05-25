import React from 'react';
import { Route } from 'react-router';
import Card from "react-bootstrap/Card";
import {BehaviorList} from "../behavior/BehaviorList";
import {BehaviorPost} from "../../shared/components/behavior-post/BehaviorPost";
import CardActionArea from '@material-ui/core/CardActionArea';
import CardActions from '@material-ui/core/CardActions';
import CardContent from '@material-ui/core/CardContent';
import CardMedia from '@material-ui/core/CardMedia';
import Button from '@material-ui/core/Button';
import Typography from '@material-ui/core/Typography';

// import logo from "./../images/recipe-placeholder.jpg";



export const Business = ({business,behaviors, votes}) => {
	return (

//this gives form to the recipes in the list on DOM
		<Route render={ ({history}) => (


			<>

			{/* <img src ={business.businessAvatar} alt=""/> */}
		
			
			<Card className="my-5 border border-dark alternate-bg ml-5 ">
			<CardMedia
			component = "img"
			height="150"
			width="150"
			 img={business.businessAvatar} 
				 title="business photo"
			 />
				<Card.Title>{business.businessName}</Card.Title>

				<a href={business.businessUrl}>Yelp Link for business</a>
				<Card.Body className="row my-3 px-5">
				<div className="col-4 pt-5" style={{width:25}}>
					<BehaviorPost behaviorBusinessId = {business.businessId}/>
				</div>
					<div style={{width: 50, order: 1}} className="col-8">
						<BehaviorList behaviors={behaviors} />
					</div>
				</Card.Body>
			</Card>

			</>
		)}/>
	)
};