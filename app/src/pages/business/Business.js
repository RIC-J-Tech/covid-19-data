import React from 'react';
import { Route } from 'react-router';
import Card from "react-bootstrap/Card";
import {Link} from "react-router-dom";
import {BehaviorList} from "../behavior/BehaviorList";
import {BehaviorPost} from "../../shared/components/behavior-post/BehaviorPost";

// import logo from "./../images/recipe-placeholder.jpg";

export const Business = ({business,behaviors}) => {
	return (

//this gives form to the recipes in the list on DOM
		<Route render={ ({history}) => (


			<>

			<Card className="my-5 border border-dark alternate-bg mx-5 ">
				<Card.Title>{business.businessName}</Card.Title>
				<Card.Link href={business.businessUrl}>Yelp Link for business</Card.Link>
				<Card.Body className="row my-3 px-5">
				<div className="col-8">
					<BehaviorList behaviors={behaviors} />
				</div>
					<div className="col-4">
						<BehaviorPost behaviorBusinessId = {business.businessId}/>
					</div>


				</Card.Body>

			</Card>

			</>
		)}/>
	)
};