import React from "react";
import {Route} from "react-router";
import Card from "react-bootstrap/Card";
import {BehaviorList} from "../../../pages/behavior/BehaviorList";

export const  BehaviorCard = ({behavior}) => {
	return (

//this gives form to the recipes in the list on DOM
		<Route render={ ({history}) => (


			<>

				<Card className="my-5 border border-dark alternate-bg mx-5">
					<Card.Body className="row my-3 px-3">
						<BehaviorList behavior={behavior} />
					</Card.Body>
				</Card>

			</>
		)}/>
	)
};