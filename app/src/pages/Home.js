import React from "react"
import Card from "react-bootstrap/Card";
import {BehaviorPost} from "../components/behaviorpost";


export const Home = () => {
	return (
		<>
<BehaviorPost behaviorContent="Wear mask" behaviorRating = {5} />
				<Card style={{ width: '50rem' }}>
					<Card.Img variant="top" src="holder.js/100px180" alt="photo" />
					<div className="red">
					<Card.Body>
						<Card.Title>Card Title</Card.Title>
						<Card.Text>
							Some quick example text to build on the card title and make up the bulk of
							the card's content.
						</Card.Text>
					</Card.Body>
					</div>
				</Card>

		</>
	)
};