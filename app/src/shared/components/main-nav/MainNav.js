import React, {useEffect, useState} from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {LinkContainer} from "react-router-bootstrap";
import {Form, FormControl, Button} from "react-bootstrap";
import {SignUpModal} from "./sign-up/SignUpModal";
import {SignInModal} from "./sign-in/SignInModal";
import {SearchFormContent} from "../SearchForm/SearchForm";
import {useDispatch, useSelector} from "react-redux";
import {Home} from "../../../pages/home/Home"
import {getBusinessesByBusinessName, getTopBusinesses} from "../../actions/get-businesses";
import {TestBusiness} from "../../../pages/business/TestBusiness";


export const MainNav = (props) => {
	return(
		<Navbar bg="primary" variant="dark">
			<a href="#">
				<img src="../../../../public/covid.JPG" alt="logo"/>
			</a>
			<LinkContainer exact to="/" >
				<Navbar.Brand>Pan-Ops</Navbar.Brand>
			</LinkContainer>
			<Nav className="mr-auto">
				<LinkContainer exact to="/Profile">
					<Nav.Link>profile</Nav.Link>
				</LinkContainer>
				<SignUpModal/>
				<SignInModal/>

				<SearchFormContent/>
			</Nav>
		</Navbar>
	)
};