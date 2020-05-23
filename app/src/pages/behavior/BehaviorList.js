import React, {useEffect} from 'react';
import {ListGroup, ListGroupItem } from 'react-bootstrap';
import {useDispatch, useSelector} from "react-redux";
import {getBehaviorByBehaviorBusinessId} from "../../shared/actions/get-behaviors";

export const BehaviorList = ({behaviors}) => {

	return (
		<>
			{/*todo only want to list behaviors if they exist. maybe check for behavior count or null here and only render if there are behaviors.*/}
			<ListGroup>
				{behaviors.map(behavior => <ListGroup.Item>{behavior.behaviorContent}</ListGroup.Item>)}
			</ListGroup>
		</>
	)
}