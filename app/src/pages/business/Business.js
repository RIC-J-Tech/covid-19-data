import React, {useEffect} from 'react';
import {useSelector, useDispatch} from "react-redux";
import {BusinessList} from "./BusinessList";
import {getAllBusinesses} from "../../shared/actions/get-businesses";

export const Business= () => {

	// use selector to set users to users stored in state
	const businesses = useSelector(state => state.businesses);

	// use dispatch from redux to dispatch actions
	const dispatch = useDispatch();

	// get businesses
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
					<th><h4>Business Id</h4></th>
					<th><h4>Business Name</h4></th>
					<th><h4>Longitude</h4></th>
					<th><h4>Latitude</h4></th>
					<th><h4>Yelp Id</h4></th>
					<th><h4>Website</h4></th>
				</tr>
				</thead>
				<BusinessList businesses={businesses}/>
			</table>
		</main>
	)
};
