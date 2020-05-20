import React, {useEffect} from 'react';
import {useSelector, useDispatch} from "react-redux";
import {BusinessList} from "./businessList";
import {getAllBusinesses} from "../../shared/actions/get-businesses";
import Card from "react-bootstrap/Card";
import {business} from "../../components/business";

export const Home= () => {

	// use selector to set users to users stored in state
	const users = useSelector(state => state.users);

	// use dispatch from redux to dispatch actions
	const dispatch = useDispatch();

	// get users
	const effects = () => {
		dispatch(getAllBusinesses())
	};

	// set inputs to an empty array before update
	const inputs = [];

	// do this effect on component update
	useEffect(effects, inputs);

	return (
		<main className="container">
			<table className="table table-responsive table-hover table-dark">
				<thead>
				<tr>
					<th><h4>User Id</h4></th>
					<th><h4>Name</h4></th>
					<th><h4>Email</h4></th>
					<th><h4>Phone</h4></th>
					<th><h4>Username</h4></th>
					<th><h4>Website</h4></th>
				</tr>
				</thead>
				<BusinessList businesses={business}/>
			</table>
		</main>
	)
};



