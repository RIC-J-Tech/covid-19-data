import React, {useEffect} from 'react';
import {useSelector, useDispatch} from "react-redux";
import {ProfileList} from "../profile/ProfileList";
// import {getAllProfiles, getProfileByEmail} from "../../shared/actions/get-profile";
import Grid from '@material-ui/core/Grid';
import axios from 'axios';
import Behavior, { Behaviors } from '../behavior/Behaviors'
import Profile from '../profile/Profile'

export const Home= () => {



	return (
		<main className="container">

			<h1>Home</h1>

			<Grid container spacing={10}>
				<Grid item sm={8} xs={12}>

					<p>Content...</p>

					<Behaviors Behaviors={Behaviors}/>
					{/* <ProfileList profiles={profiles}/> */}
				</Grid>

				<Grid item sm={4} xs={12}>
					<p>Business...</p>
				</Grid>
			</Grid>


		</main>
	)
};



