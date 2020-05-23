import React from 'react';
import {POCBusinessCard} from "./BusinessCard"

export const POCBusinessList = ({businesses}) => {
	return (
		businesses.map(
			business => <POCBusinessCard key={business.businessId} business={business}/>
		)
	)
}