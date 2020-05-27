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




