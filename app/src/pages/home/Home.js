import React, {useEffect} from 'react';
import {useSelector, useDispatch} from "react-redux";
import {ProfileList} from "../profile/ProfileList";
import {getAllProfiles, getProfileByEmail} from "../../shared/actions/get-profile";


export const Home= () => {

	// // use selector to set users to users stored in state
	// const profiles = useSelector(state => state.profiles);
	//
	// // use dispatch from redux to dispatch actions
	// const dispatch = useDispatch();
	//
	// // get profiles
	// const effects = () => {
	// 	dispatch(getProfileByEmail())
	// };
	//
	// // set inputs to an empty array before update
	// const inputs = [];
	//
	// // do this effect on component update
	// useEffect(effects, inputs);

	return (
			<main className="container">
				{/*<table className="table table-responsive table-hover table-dark">*/}
				{/*	<thead>*/}
				{/*	<tr>*/}
				{/*		<th><h4>Profile Id</h4></th>*/}
				{/*		<th><h4>User Name</h4></th>*/}
				{/*		<th><h4>Email</h4></th>*/}
				{/*		<th><h4>Phone No.</h4></th>*/}
				{/*		<th><h4>Avatar Url</h4></th>*/}
				{/*	</tr>*/}
				{/*	</thead>*/}
				{/*	<ProfileList profiles={profiles}/>*/}
				{/*</table>*/}
				<h1>Home</h1>
		</main>
	)
};



