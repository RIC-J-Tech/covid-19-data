import React from "react"
import Card from "react-bootstrap/Card";


export const Home = () => {
	return (
		<>

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