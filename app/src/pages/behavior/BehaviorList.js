import React, {useEffect} from 'react';
import {ListGroup, ListGroupItem } from 'react-bootstrap';
import {useDispatch, useSelector} from "react-redux";
import {getBehaviorByBehaviorBusinessId} from "../../shared/actions/get-behaviors";

export const BehaviorList = ({businessId}) => {
	// use selector to set users to users stored in state
	const behaviors = useSelector(state => state.behaviors ? state.behaviors : []);

	// use dispatch from redux to dispatch actions
	const dispatch = useDispatch();

	// get profiles
	const effects = () => {
		dispatch(getBehaviorByBehaviorBusinessId(businessId))
	};

	// set inputs to an empty array before update
	const inputs = [];

	// do this effect on component update
	useEffect(effects, inputs);

	return (
		<>
			{/*todo only want to list behaviors if they exist. maybe check for behavior count or null here and only render if there are behaviors.*/}
			<ListGroup>
				{behaviors.map(behavior => <ListGroup.Item>{behavior.behaviorContent}</ListGroup.Item>)}
			</ListGroup>
		</>
	)
}