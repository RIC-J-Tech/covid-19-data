import React, {useEffect} from 'react';
import {useSelector, useDispatch} from "react-redux";
import {BusinessList} from "./businessList";
import {getAllBusinesses} from "../../shared/actions/get-businesses";
import Card from "react-bootstrap/Card";

export const Home = () => {

	const business = useSelector(state => state.business);
	const dispatch = useDispatch();

	const effects = () => {
		dispatch(getAllBusinesses());
	};

	const inputs = [];

	useEffect(effects,inputs);

	return (
		<>
			{business.map(business => {
				return(
					<Card style={{ width: '18rem' }} key={business.businessId}>
						<Card.Img variant="top" src={business.profileAvatarUrl} />
						<Card.Body>
							<Card.Text>{business.businessName}</Card.Text>
							<Card.Text>{new Date(business.businessDate).toDateString()}</Card.Text>
							<Card.Text>
								{business.businessContent}
							</Card.Text>
						</Card.Body>
					</Card>)
			})}
		</>


	)
};


