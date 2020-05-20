import React, {useEffect} from 'react';
import {useSelector, useDispatch} from "react-redux";
import {BusinessListComponent} from "./businessList";
import {getUsers} from "../../shared/actions/get-businesses";

export const Home= () => {

	// use selector to set users to users stored in state
	const users = useSelector(state => state.users);

	// use dispatch from redux to dispatch actions
	const dispatch = useDispatch();

	// get users
	const effects = () => {
		dispatch(getUsers())
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
				<BusinessListComponent users={users}/>
			</table>
		</main>
	)
};



