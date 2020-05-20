import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {Home} from "./pages/Home/Home";
import {ProfileHomePage} from "./pages/ProfileHomePage";
import {BusinessPage} from "./pages/BusinessPage";
import Navbars from "./components/Navbars";
import Footer from "./components/Footer";
import 'bootstrap/dist/css/bootstrap.css';
import thunk from "redux-thunk";
import {Provider} from "react-redux";

import {applyMiddleware, createStore} from "redux";
import reducers from "./shared/reducers";


const store = createStore(reducers,applyMiddleware(thunk));

const Routing = () => (
	<>
		<Provider store={store}>
		<Navbars />
		<BrowserRouter>
			<Switch>

				<Route exact path="/" component={Home}/>
				<Route exact path="/BusinessPage" component={BusinessPage}/>
				<Route exact path="/ProfileHomePage" component={ProfileHomePage}/>

			</Switch>
		</BrowserRouter>
		<Footer />
		</Provider>
	</>
);
ReactDOM.render(Routing(store) , document.querySelector("#root"));