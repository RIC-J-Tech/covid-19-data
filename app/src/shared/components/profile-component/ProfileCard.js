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

// import logo from "./../images/recipe-placeholder.jpg";
const styles ={
    card:{
        display:'flex',
        marginBottom: 20
    },
    image:{
        minWidth: 200
    },
    content:{
        padding:25
    }
    
};



export const ProfileCard = ({profile,behaviors}) => {
  console.log(behaviors)
   
	return (
<Route render={ ({history}) => (
<>
        
        <Card styles={styles.card}>
              <CardMedia>
                  <img src='https://via.placeholder.com/150' styles={styles.image} />
              </CardMedia>
              
            <CardContent  >
                <Typography variant ="h5" color="primary">{profile.profileUsername}</Typography>
                <Typography variant ="body2" color ="textSecondary">{profile.profilePhone}</Typography>
                {behaviors.map(behavior=> <Typography key={behavior.behaviorId} variant ="body1">{behavior.behaviorContent}</Typography>)}
                

            </CardContent>
             

        </Card>
        </>

        
		)}/>
	)
};