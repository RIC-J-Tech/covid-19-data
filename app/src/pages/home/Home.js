import React, {useEffect} from 'react';
import {useSelector, useDispatch} from "react-redux";

import {ProfileList} from "../profile/ProfileList";
// import {getAllProfiles, getProfileByEmail} from "../../shared/actions/get-profile";
import Grid from '@material-ui/core/Grid';
import axios from 'axios';
import Profile from '../profile/Profile'

import {getAllBusinesses, getBusinessByBusinessName} from "../../shared/actions/get-businesses";
import {BusinessList} from "../business/BusinessList";
import {getAllBehaviors} from "../../shared/actions/get-behaviors";
import {Business} from "../business/Business";
import {getAllVotes} from "../../shared/actions/get-votes";
import profileReducer from '../../shared/reducers/profileReducer';

export const Home= () => {

	// use selector to set users to users stored in state
	const businesses = useSelector(state => state.businesses ? state.businesses : []);
	const behaviors = useSelector(state => state.behaviors ? state.behaviors : []);
	const votes = useSelector(state => state.votes ? state.votes : [])

	// use dispatch from redux to dispatch actions
	const dispatch = useDispatch();

	// get profiles
	const effects = () => {
		// dispatch(getAllBusinesses())
		dispatch(getBusinessByBusinessName(""))
		dispatch(getAllBehaviors())
		dispatch(getAllVotes())
	};

	// set inputs to an empty array before update
	const inputs = [];

	// do this effect on component update
	useEffect(effects, inputs);
	// console.log(behaviors)
console.log(votes);
	return (
		<main className="container">
			<h1>I am the home page</h1>

			{
				businesses.map(
			business => <Business key={business.businessId} business={business}  behaviors={behaviors.filter(behavior =>
				behavior.behaviorBusinessId === business.businessId
			)} 

			/>)

			}

			{/*<BusinessList businesses={businesses}/>*/}

		</main>
	)
};
// businesses.map(
// 	business => <Business key={business.businessId} business={business} behaviors={behaviors.filter(behavior =>
// 		behavior.behaviorBusinessId === business.businessId
// 	)}