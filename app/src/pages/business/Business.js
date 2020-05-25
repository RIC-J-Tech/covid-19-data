import React from 'react';
import { Route } from 'react-router';
import Card from "react-bootstrap/Card";
import {BehaviorList} from "../behavior/BehaviorList";
import {BehaviorPost} from "../../shared/components/behavior-post/BehaviorPost";


// import logo from "./../images/recipe-placeholder.jpg";



export const Business = ({business,behaviors, votes}) => {
	return (

//this gives form to the recipes in the list on DOM
		<Route render={ ({history}) => (


			<>
			{/* <img src = "https://s3-media3.fl.yelpcdn.com/bphoto/yRsxU5SyPhsSxMa9d8SZjw/o.jpg" alt=""/> */}
		
			
			<Card className="my-5 border border-dark alternate-bg ml-5 ">
			<Card.Media
			component = "img"
			height="150"
			width="150"
			 image={business.businessAvatar} 
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