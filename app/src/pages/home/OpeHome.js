import React, {useEffect, useState} from 'react';
import {useSelector, useDispatch} from "react-redux";
import {getBusinessesByBusinessName, getTopBusinesses} from "../../shared/actions/get-businesses";
import {getAllBehaviors} from "../../shared/actions/get-behaviors";
import {TestBusiness} from "../business/TestBusiness";
import {OpeBusiness} from "../business/OpeBusiness";
import {getAllVotes} from "../../shared/actions/get-votes";
import Navbar from "react-bootstrap/Navbar";
import { SearchFormContent } from '../../shared/components/SearchForm/SearchForm';


import Grid from '@material-ui/core/Grid';
import {BehaviorList} from "../behavior/BehaviorList";


export const OpeHome= () => {

	const [searchWord, setSearchWord] = useState('');

	// use selector to set users to users stored in state
	const businessState = useSelector(state => state.businesses ? state.businesses : []);
	const behaviors = useSelector(state => state.behaviors ? state.behaviors : []);


	const filterBusiness = businessState.filter(
		businesses => businesses.businessName.toLowerCase().includes(searchWord) || businesses.businessUrl.toLowerCase().includes(searchWord)
	);

	// use dispatch from redux to dispatch actions
	const businesses = filterBusiness, dispatch = useDispatch();

	// get profiles
	const effects = () => {
		// dispatch(getAllBusinesses())
		dispatch(getTopBusinesses())
		dispatch(getAllBehaviors())
		dispatch(getAllVotes())
	};
	const search = (businessName)=> {
		dispatch (getBusinessesByBusinessName(businessName))
	};
	// set inputs to an empty array before update
	const inputs = [];
	// do this effect on component update
	useEffect(effects, inputs);
	return (
		<main className="container">
			<Navbar bg="white" variant="dark">
				<SearchFormContent searchWord={searchWord} setSearchWord={setSearchWord}/>
			</Navbar>

			{
						businesses.map(
							business => <TestBusiness key={business.businessId} business={business} searchWord={searchWord} behaviors={behaviors.filter(behavior =>
								behavior.behaviorBusinessId === business.businessId
							)}

							/>)

					}



					</main>
	)
};
// businesses.map(
//  business => <Business key={business.businessId} business={business} behaviors={behaviors.filter(behavior =>
//      behavior.behaviorBusinessId === business.businessId
//  )}
//
//  <Grid container spacing={5}>
// 				<Grid item sm={6} xs={12}>
// 					Post Go here...
// 					{
// 						businesses.map(
// 							business => <OpeBusiness key={business.businessId} business={business} searchWord={searchWord} behaviors={behaviors.filter(behavior =>
// 								behavior.behaviorBusinessId === business.businessId
// 							)}
//
// 							/>)
//
// 					}
// 				</Grid>
// 				<Grid item sm={6} xs={12}>
// 					Business Card goes here...
// 					{
// 						businesses.map(
// 							business => <TestBusiness key={business.businessId} business={business} searchWord={searchWord} behaviors={behaviors.filter(behavior =>
// 								behavior.behaviorBusinessId === business.businessId
// 							)}
//
// 							/>)
//
// 					}
// 					{/*<Profile />*/}
// 				</Grid>
// 			</Grid>



