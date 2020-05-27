import React, {useEffect, useState} from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {LinkContainer} from "react-router-bootstrap";
import {SignUpModal} from "./sign-up/SignUpModal";
import {SignInModal} from "./sign-in/SignInModal";
import {SearchFormContent} from "../SearchForm/SearchForm";
import NavDropdown from "react-bootstrap/NavDropdown";


export const MainNav = (props) => {

	return(
		<Navbar bg="light" expand="lg">
			<LinkContainer exact to="/" >
				<Navbar.Brand>Pan-Ops</Navbar.Brand>
			</LinkContainer>
			<Navbar.Toggle aria-controls="basic-navbar-nav" />
			<Navbar.Collapse id="basic-navbar-nav">
				<Nav className="mr-auto">
					<LinkContainer exact to="/BusinessPage"
					><Nav.Link>Local Businesses</Nav.Link>
					</LinkContainer>
					<SignUpModal/>
					<SignInModal/>
					<NavDropdown title="More" id="basic-nav-dropdown">
						<NavDropdown.Item exact to="/Profile"><LinkContainer exact to="/Profile"
						><Nav.Link>My Account</Nav.Link></LinkContainer></NavDropdown.Item>

						<NavDropdown.Item exact to ="/About"><LinkContainer exact to="/About"
						><Nav.Link>About</Nav.Link>
						</LinkContainer></NavDropdown.Item>

					</NavDropdown>
				</Nav>
				<SearchFormContent/>

			</Navbar.Collapse>
		</Navbar>

	)
};