import React, {useEffect, useState} from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {LinkContainer} from "react-router-bootstrap";
import {SignUpModal} from "./sign-up/SignUpModal";
import {SignInModal} from "./sign-in/SignInModal";
import {SearchFormContent} from "../SearchForm/SearchForm";

export const MainNav = (props) => {
	return(
		<container>
		<Navbar bg="primary" variant="dark">
			<LinkContainer exact to="/" >
				<Navbar.Brand>Pan-Ops</Navbar.Brand>
			</LinkContainer>
			<Nav className="align-self-centers">
				<LinkContainer exact to="/BusinessPage"
				><Nav.Link>Business</Nav.Link>
				</LinkContainer>
				<SignUpModal/>
				<SignInModal/>
				<LinkContainer exact to="/Profile"
				><Nav.Link>My Account</Nav.Link>
				</LinkContainer>
				<div className="d-inline-flex row-cols-1 align-item-end">
					<SearchFormContent/>
				</div>

			</Nav>
		</Navbar>
		</container>
	)
};