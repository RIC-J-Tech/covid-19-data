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

// import logo from "./../images/recipe-placeholder.jpg";
const styles ={
    card:{
        display:'flex'
    }
}



export const ProfileCard = ({profile}) => {
  
   
	return (
<Route render={ ({history}) => (
<>

        <Card>
              
            <CardContent  >
                <Typography variant ="h5">{profile.profileUsername}</Typography>
                <Typography variant ="body2" color ="textSecondary">{profile.profilePhone}</Typography>
                <Typography variant ="body1">{profile.profileEmail}</Typography>

            </CardContent>
             

        </Card>
        </>

        
		)}/>
	)
};