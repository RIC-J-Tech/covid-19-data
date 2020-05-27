import React from 'react';
import {ListGroup, ListGroupItem } from 'react-bootstrap';
import Grid from "@material-ui/core/Grid"
import {ProfileCard} from "../../shared/components/profile-component/ProfileCard"



export const ProfileList = ({profiles,behaviors}) => {
console.log(behaviors)
	return (
		profiles.map(
profile => <ProfileCard key={profile.profileId} profile={profile} behaviors={behaviors}/>
		)
	)
}