import React, { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import { getAllProfiles } from "../../shared/actions/get-profile";
import { getAllBehaviors } from "../../shared/actions/get-behaviors";
import { getAllVotes } from "../../shared/actions/get-votes";
import { ProfileList } from "../profile/ProfileList";
import {TestProfileCard } from "../../shared/components/profile-component/TestProfileCard";
<<<<<<< HEAD
import { makeStyles } from '@material-ui/core/styles';
=======
import { ListGroup } from 'react-bootstrap';
>>>>>>> test design for profile page looking pretty good


//MUI
import Grid from "@material-ui/core/Grid";

//Javascript Package
import * as jwtDecode from "jwt-decode";
import { BehaviorProfile } from "../../shared/components/profile-component/BehaviorProfile";
<<<<<<< HEAD


const useStyles = makeStyles((theme) => ({
	root: {
	  width: '100%',
	  maxWidth: '36ch',
	  marginLeft: 310,
	  
	}
  }));
  


export const TestProfile = () => {
	const classes = useStyles();

=======
import { BehaviorCard } from "../../shared/components/behavior-post/BehaviorCard";

export const TestProfile = () => {
>>>>>>> test design for profile page looking pretty good
  const profiles = useSelector((state) =>
    state.profiles ? state.profiles : []
  );
  const behaviors = useSelector((state) =>
    state.behaviors ? state.behaviors : []
  );
  const votes = useSelector((state) => (state.votes ? state.votes : []));
  const businesses = useSelector((state) =>
    state.businesses ? state.businesses : []
  );

  // use dispatch from redux to dispatch actions
  const dispatch = useDispatch();

  // get profiles
  const effects = () => {
    dispatch(getAllProfiles());
    dispatch(getAllBehaviors());
    dispatch(getAllVotes());
  };

  // set inputs to an empty array before update
  const inputs = [];

  // do this effect on component update
  useEffect(effects, inputs);
  console.log(behaviors);

  let loggedInUser =
    window.localStorage.getItem("jwt-token") !== null
      ? jwtDecode(window.localStorage.getItem("jwt-token")).auth.profileId
      : "none";
  console.log(loggedInUser);
  let list = [];
  if (loggedInUser) {
    list = profiles.filter((profile) => profile.profileId === loggedInUser);
  }
<<<<<<< HEAD
  
  return (
    <main className="container">
      <h1 className={classes.root} style={{color:"#aa00ff"}}>WELCOME TO PAN OPS</h1>
      {/* <h3>List of Behaviors</h3> */}
      <h3>Profile</h3>

      <Grid container spacing={5}>
=======
  console.log(list);
  return (
    <main className="container">
      <h1>I am the Profile page</h1>
      {/* <h3>List of Behaviors</h3> */}
      <h3>Profile</h3>

      <Grid container spacing={10}>
>>>>>>> test design for profile page looking pretty good
        <Grid item sm={8} xs={12}>
          {list.map((profile) => (
            <TestProfileCard
              key={profile.profileId}
              profile={profile}
              behaviors={behaviors.filter(
                (behavior) => behavior.behaviorProfileId === profile.profileId
              )}
            />
          ))}
        </Grid>

        <Grid item sm={4} xs={12}>
<<<<<<< HEAD
         
=======
          <p>SOmething Goes HERE...</p>
		 
>>>>>>> test design for profile page looking pretty good
		  {list.map((profile) => (
            <BehaviorProfile
              key={profile.profileId}
              profile={profile}
              behaviors={behaviors.filter(
                (behavior) => behavior.behaviorProfileId === profile.profileId
              )}
            />
          ))}
           
<<<<<<< HEAD
         
=======
          ))}
>>>>>>> test design for profile page looking pretty good
        </Grid>
      </Grid>


    </main>
  );
};
export default TestProfile