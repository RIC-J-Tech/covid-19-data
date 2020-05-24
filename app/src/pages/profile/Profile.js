import React, {useEffect} from 'react'
import {useDispatch, useSelector} from "react-redux";
import { getAllProfiles} from "../../shared/actions/get-profile";
import {getAllBehaviors} from "../../shared/actions/get-behaviors";
import {getAllVotes} from "../../shared/actions/get-votes";
import {ProfileList} from "../profile/ProfileList"

import Grid from "@material-ui/core/Grid"



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
			{/* <h3>List of Behaviors</h3> */}
			<h3>Profile</h3>

			<Grid container spacing={10}>
			<Grid item sm={8} xs={12}>
	<ProfileList key={profiles.profileId} profiles={profiles} behaviors={behaviors.filter(behavior =>
				behavior.behaviorBusinessId === profiles.profileId
			)}/>
			</Grid>

			<Grid item sm={4} xs={12}>
				<p>SOmething Goes HERE...</p>
			</Grid>
		
</Grid>
			{/* <ProfileCard profiles={profiles}/> */}


			{/* {profiles.map(
				profile => <BehaviorList key={profile.profileId} profile={profile} behaviors={behaviors.filter(behavior =>
					behavior.behaviorProfileId === profile.profileId
				)}

				/> )
				}				 */}

			{/*<profileList profilees={businesses}/>*/}
		</main>
	)
};

export default Profile