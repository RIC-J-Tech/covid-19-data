import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {Home} from "./pages/Home";
import {ProfileHomePage} from "./pages/ProfileHomePage";
import {BusinessPage} from "./pages/BusinessPage";
import Navbars from "./components/Navbars";
import Footer from "./components/Footer";

const Routing = () => (
	<>
		<Navbars />
		<BrowserRouter>
			<Switch>

				<Route exact path="/" component={Home}/>
				<Route exact path="/BusinessPage" component={BusinessPage}/>
				<Route exact path="/ProfileHomePage" component={ProfileHomePage}/>

			</Switch>
		</BrowserRouter>
		<Footer />
	</>
);
ReactDOM.render(<Routing/>, document.querySelector('#root'));