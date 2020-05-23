import React from 'react';
import { Route } from 'react-router';
import Card from "react-bootstrap/Card";
import {Link} from "react-router-dom";

// import logo from "./../images/recipe-placeholder.jpg";
import {BehaviorList} from "../behavior/BehaviorList"

export const Business = ({business}) => {
	return (

//this gives form to the recipes in the list on DOM
		<Route render={ ({history}) => (
			<Card className="my-5 border border-dark alternate-bg mx-5" key={business.businessId}>
				<Card.Title>{business.businessName}</Card.Title>
				<Card.Subtitle>{business.businessId}</Card.Subtitle>
				<Card.Link href={business.businessUrl}>Yelp Link for business</Card.Link>
				<Card.Body className="row my-3 px-3">
					<BehaviorList businessId={business.businessId} />
				</Card.Body>
			</Card>
		)}/>
	)
};