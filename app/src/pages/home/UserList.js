import React from 'react';
import { Route } from 'react-router';

const BusinessListComponent = ({businesses}) => {

	return (
		<Route render={ ({history}) => (
			<tbody>
				{businesses.map(business => (
					<tr key={business.businessId} onClick={() => {history.push(`business/${business.businessId}`)}}>
						<td>{business.businessId}</td>
						<td>{business.businessName}</td>
						<td>{business.businessLat}</td>
						<td>{business.businessLng}</td>
						<td>{business.businessYelpId}</td>
						<td>{business.businessUrl}</td>
					</tr>
				))}
			</tbody>
		)}/>
	)
};

export const BusinessList = (BusinessListComponent);