import React, {useEffect} from 'react';
import {ListGroup, ListGroupItem } from 'react-bootstrap';


export const BehaviorList = ({behaviors}) => {

	return (
		<>
			{/*todo only want to list behaviors if they exist. maybe check for behavior count or null here and only render if there are behaviors.*/}
			
				{behaviors.map(behavior => {
						return(

							<ListGroup.Item key={behavior.behaviorId}> {behavior.behaviorContent} </ListGroup.Item>

						)
					}

				)}

		


		</>
	)
}