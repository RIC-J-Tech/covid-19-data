import React from "react"
import Card from "react-bootstrap/Card";
import Navbar from 'react-bootstrap/Navbar';
import Nav from 'react-bootstrap/Nav';
import NavDropdown from 'react-bootstrap/NavDropdown';
import Form from 'react-bootstrap/Form';
import Button from 'react-bootstrap/Button';
import FormControl from "react-bootstrap/FormControl";


export const AboutUs = () => {
	return (
		<>
						<Navbar bg="light" expand="lg">
            				<Navbar.Brand href="#home">React-Bootstrap</Navbar.Brand>
            				<Navbar.Toggle aria-controls="basic-navbar-nav" />
            				<Navbar.Collapse id="basic-navbar-nav">
            					<Nav className="mr-auto">
            						<Nav.Link href="#home">Home</Nav.Link>
            						<Nav.Link href="#link">Link</Nav.Link>
            						<NavDropdown title="Dropdown" id="basic-nav-dropdown">
            							<NavDropdown.Item href="#action/3.1">Action</NavDropdown.Item>
            							<NavDropdown.Item href="#action/3.2">Another action</NavDropdown.Item>
            							<NavDropdown.Item href="#action/3.3">Something</NavDropdown.Item>
            							<NavDropdown.Divider />
            							<NavDropdown.Item href="#action/3.4">Separated link</NavDropdown.Item>
            						</NavDropdown>
            					</Nav>
            					<Form inline>
            						<FormControl type="text" placeholder="Search" className="mr-sm-2" />
            						<Button variant="outline-success">Search</Button>
            					</Form>
            				</Navbar.Collapse>
            			</Navbar>

            			<div className="">
				<Card style={{ width: '18rem' }}>
					<Card.Img variant="top" src="holder.js/100px180" />
					<Card.Body>
						<Card.Title>Card Title</Card.Title>
						<Card.Text>
							Some quick example text to build on the card title and make up the bulk of
							the card's content.
						</Card.Text>
					</Card.Body>
				</Card>
				</div>
		</>
	)
};