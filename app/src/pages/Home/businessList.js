import React from 'react';
import { Route } from 'react-router';

const BusinessListComponent = ({business}) => {

	return (
		<Route render={ ({history}) => (
			<tbody>
			{console.log(business)}
			</tbody>
		)}/>
	)
};

export const BusinessList = (BusinessListComponent);