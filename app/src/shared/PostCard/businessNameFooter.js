import React  from 'react';
import {useSelector} from "react-redux";


export const BusinessNameFooter = ({businessId}) => {


	const business = useSelector((state) => {
		return state.business ? state.business.find( business => businessId === business.businessId) : null
	});
	return(
		<>
			{business && <h3>{business.businessName}</h3>}
		</>
	)
};