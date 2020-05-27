import React, {useEffect, useState} from 'react';
import {useSelector, useDispatch} from "react-redux";
import {getBusinessesByBusinessName, getTopBusinesses} from "../../shared/actions/get-businesses";
import {getAllBehaviors} from "../../shared/actions/get-behaviors";
import {getAllVotes} from "../../shared/actions/get-votes";
import Business from "../../pages/business/Business";
import Grid from "@material-ui/core/Grid";

export const Home= () => {

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


		<main className="container" >
			<div className="container-fluid" style={{margin:"1% 30% 15% 30%",width:"200"}}>
				<h1>WELCOME TO PAN OPS</h1>
				<div className="container-fluid" style={{margin:"1%"}}>
					<h4>We cherish you honesty in telling the world what you witness</h4>
				</div>
			</div>



			<Grid container spacing={4}>
				{
					businesses.map(
						business =>  <Grid item xs={12} sm={12} md={6}>
							<Business key={business.businessId} business={business} searchWord={searchWord} behaviors={behaviors.filter(behavior =>
								behavior.behaviorBusinessId === business.businessId
							)}

							/> </Grid>)

				}

				`					</Grid>


		</main>
	)
};
