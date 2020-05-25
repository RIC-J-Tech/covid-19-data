import React from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {LinkContainer} from "react-router-bootstrap";
import {Form, FormControl, Button} from "react-bootstrap";
import {SignUpModal} from "./sign-up/SignUpModal";
import {SignInModal} from "./sign-in/SignInModal";
//import {BehaviorList} from "../../../pages/behavior/BehaviorList";
//import {Profile} from "../../../pages/profile/Profile"
 


export const MainNav = (props) => {
	return(
		<Navbar bg="primary" variant="dark">
			<LinkContainer exact to="/" >
				<Navbar.Brand>Pan-Ops</Navbar.Brand>
			</LinkContainer>
			<Nav className="mr-auto">
				<LinkContainer exact to="/Profile">
					<Nav.Link>profile</Nav.Link>
				</LinkContainer>
				<SignUpModal/>
				<SignInModal/>
				<LinkContainer exact to="/image"
				><Nav.Link>image</Nav.Link>
				</LinkContainer>
			</Nav>
			{/*<label htmlFor="search">Search by Business Name</label>*/}
			{/*<input type="text" value ={props.inputValue} onChange={props.businessFilterOnChange}/>*/}

			<Form inline>
				<FormControl type="text" placeholder="Search" className="mr-sm-2" />
			</Form>
			<Form inline>
				<Button variant="outline-info">Search</Button>
			</Form>
		</Navbar>
	)
};