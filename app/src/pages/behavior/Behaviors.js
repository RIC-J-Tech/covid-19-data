import React,{Component} from 'react';
import withStyles from '@material-ui/core/styles/withStyles';
import {useSelector, useDispatch} from "react-redux";
import { getAllProfiles} from "../../shared/actions/get-profile";
import {useEffect} from 'react'


//Mui imports
import Card from '@material-ui/core/Card';
import CardHeader from '@material-ui/core/CardHeader';
import CardMedia from '@material-ui/core/CardMedia';
import CardContent from '@material-ui/core/CardContent';
import Typography from '@material-ui/core/Typography';




const styles={
card:{
    display: 'flex',
    marginBottom: 200
},
image:{
minWidth: 200,
},
content:{
    padding:25
    ,ObjectFit: 'cover'
}
}


export const Behaviors =({Profiles})=>{
    const profiles = useSelector(state => (state.profile ? state.profile : []));
	const behaviors = useSelector(state =>(state.profile ? state.profile : []));
console.log(profiles.profileUsername)
    
// use dispatch from redux to dispatch actions
const dispatch = useDispatch();

// get profiles
const effects = () => {
    dispatch(getAllProfiles())
};

// set inputs to an empty array before update
const inputs = [];

// do this effect on component update
useEffect(effects, inputs);
	

   return (
            <Card>
            <CardMedia
             image={profiles.profileAvatarUrl}
            title ="Profile image" className={styles.image}/>
            <CardContent>
                <Typography variant ="h5">{profiles.profileUsername}</Typography>
                <Typography variant ="body2">Profile Username</Typography>
                <Typography variant ="body1">Profile Username</Typography>

            </CardContent>


            </Card>

   
   
   )
}

export default withStyles(styles)(Behaviors)