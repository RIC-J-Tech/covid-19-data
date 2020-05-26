import React,{useEffect} from 'react';
import { Route } from 'react-router';
import {useSelector, useDispatch} from "react-redux";
//MUI stuff
import Typography from '@material-ui/core/Typography';
import { makeStyles } from '@material-ui/core/styles';
import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import Divider from '@material-ui/core/Divider';
import ListItemText from '@material-ui/core/ListItemText';
import ListItemAvatar from '@material-ui/core/ListItemAvatar';
import Avatar from '@material-ui/core/Avatar';
import { ListGroup } from 'react-bootstrap';
import {BehaviorList} from '../../../pages/behavior/BehaviorList'



const useStyles = makeStyles((theme) => ({
  root: {
    width: '100%',
    maxWidth: '36ch',
    backgroundColor: theme.palette.background.paper,
  },
  inline: {
    display: 'inline',
  },
}));


// import logo from "./../images/recipe-placeholder.jpg";
const card ={
    
       
    }
const image= {
        minWidth: 200,
        marginLeft: 20
    }

   const content={
        padding:25
    }
    




export const TestProfileCard = ({profile,behaviors,businesses}) => {
  
  const classes = useStyles();
	return (
<Route render={ ({history}) => (

<>

<List className={classes.root}>
      <ListItem alignItems="flex-start">
        <ListItemAvatar>
          <Avatar alt="Remy Sharp" src="https://via.placeholder.com/150" />
        </ListItemAvatar>
        <ListItemText
          primary="Brunch this weekend?"
          secondary={
            <React.Fragment>
              <Typography
                component="span"
                variant="body2"
                className={classes.inline}
                color="textPrimary"
              >
                {profile.profileUsername}
              </Typography>
            </React.Fragment>
          }
        />
      </ListItem>
<<<<<<< HEAD
  
=======

      <Divider variant="inset" component="li" />
      
      
>>>>>>> test design for profile page looking pretty good
    </List>

</>
)}

/>
)
};
