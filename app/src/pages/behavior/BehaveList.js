import React, {useEffect} from 'react';
import {ListGroup, ListGroupItem } from 'react-bootstrap';

export const BehaveList = ({behaviors}) => {

		return (	
				behaviors.map(
						behavior => <p> key={behavior.behaviorId} behavior={behavior}</p>
		)
	)
		
	}