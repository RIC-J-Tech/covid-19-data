import React from 'react';
import {Business} from "./Business"

export const BusinessList = ({businesses}) => {

	return (
		businesses.map(
			business => <Business key={business.businessId} business={business}/>
		)
	)
}