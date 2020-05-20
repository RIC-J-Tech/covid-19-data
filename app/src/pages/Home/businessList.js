import React from 'react';
import { Route } from 'react-router';

// business.businessName = undefined;
const BusinessListComponent = ({businesses}) => {

	return (
		<Route render={ ({history}) => (
			<tbody>
			{businesses.map(business => (
				<tr key={business.businessId} onClick={() => {history.push(`business/${business.businessId}`)}}>
					<td>{business.businessId}</td>
					<td>{business.businessName}</td>
					
				</tr>
			))}
			</tbody>
		)}/>
	)
};

export const BusinessList = (BusinessListComponent);