import React from 'react';
import { Route } from 'react-router';
import Card from "react-bootstrap/Card";
import {BehaviorList} from "../behavior/BehaviorList";
import {BehaviorPost} from "../../shared/components/behavior-post/BehaviorPost";
import CardActionArea from '@material-ui/core/CardActionArea';
import CardActions from '@material-ui/core/CardActions';
import CardContent from '@material-ui/core/CardContent';
import CardMedia from '@material-ui/core/CardMedia';
import Button from '@material-ui/core/Button';
import Typography from '@material-ui/core/Typography';
import { makeStyles } from '@material-ui/core/styles';

// import logo from "./../images/recipe-placeholder.jpg";


const useStyles = makeStyles({
    root: {
      maxWidth: 345,
    },
  });
export const TestBusiness = ({business,behaviors, votes}) => {
    const classes = useStyles();
	return (

//this gives form to the recipes in the list on DOM
		<Route render={ ({history}) => (


			<>
AAA
			{/* <img height="160" width="190" src ={business.businessAvatar} alt=""/> */}
		
			
			<Card className="my-5 border border-dark alternate-bg ml-5 ">
            <div className ="row d-flex-column">

                 
        
			
				   

				<a className="ml-5 p-2 align-self-center" href={business.businessUrl}> <Card.Title className="ml-5 p-2 align-self-center">{business.businessName}</Card.Title></a>
            </div>
           <CardMedia className="align-self-center">

                     <img height="300" width="350" src ={business.businessAvatar} alt="business photo"/> 
                        </CardMedia>
				<Card.Body className="row my-3 px-5">
                
				<div className="col-4 pt-5 align-self-start " style={{width:25}}>
					<BehaviorPost behaviorBusinessId = {business.businessId}/>
				</div>

					<div style={{width: 40,heigh:200, order: -1}} className="col-8">
						<BehaviorList behaviors={behaviors} />
					</div>

				</Card.Body>

			</Card>

			</>
		)}/>
	)
};