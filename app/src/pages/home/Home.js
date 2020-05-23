import React, {useEffect} from 'react';
import {useSelector, useDispatch} from "react-redux";

import {ProfileList} from "../profile/ProfileList";
// import {getAllProfiles, getProfileByEmail} from "../../shared/actions/get-profile";
import Grid from '@material-ui/core/Grid';
import axios from 'axios';
import Behavior, { Behaviors } from '../behavior/BehaviorList'
import Profile from '../profile/Profile'



import {getAllBusinesses, getBusinessByBusinessName} from "../../shared/actions/get-businesses";
import {BusinessList} from "../business/BusinessList";

export const Home= () => {

	// use selector to set users to users stored in state
	const businesses = useSelector(state => state.businesses ? state.businesses : []);

	// use dispatch from redux to dispatch actions
	const dispatch = useDispatch();

	// get profiles
	const effects = () => {
		// dispatch(getAllBusinesses())
		dispatch(getBusinessByBusinessName("bistro"))
	};

	// set inputs to an empty array before update
	const inputs = [];

	// do this effect on component update
	useEffect(effects, inputs);

	return (
		<main className="container">
			<h1>I am the home page</h1>
			<POCBusinessList businesses={businesses}/>
		</main>
	)
};



