import React from "react";
import {getAllVotes} from "../../actions/get-votes";
import {getAllBehaviors} from "../../actions/get-behaviors";
import {getAllProfiles} from "../../actions/get-profile"
import {Route} from "react-router";
import Card from "react-bootstrap/Card";
import {BehaviorPost} from "./BehaviorPost";
import {BehaviorList} from "../../../pages/behavior/BehaviorList";

export const  BehaviorCard = ({votes,behavior,profile}) => {
	return (

//this gives form to the recipes in the list on DOM
		<Route render={ ({history}) => (


			<>

				<Card className="my-5 border border-dark alternate-bg mx-5">
					<Card.Title>AVVD</Card.Title>
					<Card.Body className="row my-3 px-3">
						<BehaviorList behavior={behavior} />
					</Card.Body>
				</Card>

			</>
		)}/>
	)
};