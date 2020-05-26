import React,{useEffect} from 'react';
import { Route } from 'react-router';
import {useSelector, useDispatch} from "react-redux";
//MUI stuff
import Card from '@material-ui/core/Card';
import CardActionArea from '@material-ui/core/CardActionArea';
import CardActions from '@material-ui/core/CardActions';
import CardContent from '@material-ui/core/CardContent';
import CardMedia from '@material-ui/core/CardMedia';
import Typography from '@material-ui/core/Typography';
import {BehaviorList} from '../../../pages/behavior/BehaviorList'
import { ListGroup } from 'react-bootstrap';
import {Business} from '../../../pages/business/Business'
import {ProfileModal} from "./ProfileModal";

// import logo from "./../images/recipe-placeholder.jpg";
const card ={
    
       
    }
const image= {
        minWidth: 200
    }

   const content={
        padding:25
    }
    




export const ProfileCard = ({profile,behaviors,businesses}) => {
  console.log(behaviors)
   
	return (
<Route render={ ({history}) => (
<>
        
        <Card style={{
        marginBottom: 50}}>
              <CardMedia image ={profile.profileAvatarUrl}>
                  <img src={profile.profileAvatarUrl} styles={image} />
              </CardMedia>
              
            <CardContent style={content} >
                <Typography variant ="h5" color="primary">{profile.profileUsername}</Typography>
                <Typography variant ="body2" color ="Secondary">{profile.profilePhone}</Typography>
                
               <p>
               {behaviors.map(behavior=> <ListGroup.Item color="warning" key={behavior.behaviorId} variant ="body1">{behavior.behaviorContent} </ListGroup.Item> )}
            </p></CardContent>
            

        </Card>

         <ProfileModal profile={profile}/>

        </>

        
		)}/>
	)
};