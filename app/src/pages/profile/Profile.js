import React, {useEffect} from 'react'
import {useDispatch, useSelector} from "react-redux";
import { getAllProfiles} from "../../shared/actions/get-profile";
import {BehaviorCard} from "../../shared/components/behavior-post/BehaviorCard";
import {getBusinessByBusinessName} from "../../shared/actions/get-businesses";
import {getAllBehaviors} from "../../shared/actions/get-behaviors";
import {getAllVotes} from "../../shared/actions/get-votes";
import {Business} from "../business/Business";
import {BehaviorList} from "../behavior/BehaviorList";


export const Profile = () => {

   const profiles = useSelector(state => state.profiles ? state.profiles : []);
	const behaviors = useSelector(state => state.behaviors ? state.behaviors : []);
	const votes = useSelector(state => state.votes ? state.votes : [])

	// use dispatch from redux to dispatch actions
	const dispatch = useDispatch();

	// get profiles
	const effects = () => {
		// dispatch(getAllBusinesses())
		dispatch(getAllProfiles())
		dispatch(getAllBehaviors())
		dispatch(getAllVotes())
	};

	// set inputs to an empty array before update
	const inputs = [];

	// do this effect on component update
	useEffect(effects, inputs);

	return (
		<main className="container">
			<h1>I am the Profile page</h1>
			<h3>List of Behaviors</h3>

			{profiles.map(
				profile => <BehaviorList key={profile.profileId} profile={profile} behaviors={behaviors.filter(behavior =>
					behavior.behaviorProfileId === profile.profileId
				)}

				/>)}

			{/*<profileList profilees={businesses}/>*/}
		</main>
	)
};