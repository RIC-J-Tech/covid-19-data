import React from 'react';
import { Route } from 'react-router';

const BusinessListComponent = ({business}) => {

	return (
		<Route render={ ({history}) => (
			<tbody>
			{businesss.map(business => (
				<tr key={business.businessId} onClick={() => {history.push(`business/${business.businessId}`)}}>
					<td>{business.businessId}</td>
					<td>{business.businessName}</td>
					<td>{business.businessLat}</td>
					<td>{business.businessLng}</td>
					<td>{business.businessUrl}</td>
					<td>{business.businessYelpId === "Mazaya Cafe" ? " The BUSINESSNAME is Mazaya Cafe" : "NOT Mazaya Cafe"}</td>
				</tr>
			))}
			</tbody>
		)}/>
	)
};

export const BusinessList = (BusinessListComponent);