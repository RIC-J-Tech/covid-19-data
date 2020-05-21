import React from 'react';
import ReactDOM from 'react-dom';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';
import './index.css'
import thunk from "redux-thunk";
import {applyMiddleware, createStore} from "redux";
import reducers from "./shared/reducers";
import {Provider} from "react-redux";
import {Route,BrowserRouter, Switch} from "react-router-dom";
import {FourOhFour} from "./pages/four-oh-four/FourOhFour";
import {Home} from "./pages/home/Home";


const store = createStore(reducers,applyMiddleware(thunk));

const Routing = (store) => (
	<>
	<Provider store={store}>
		<BrowserRouter>
			<Switch>
				<Route exact path="/" component={Home}/>
				<Route component={FourOhFour}/>
			</Switch>
		</BrowserRouter>
	</Provider>
	</>
);

ReactDOM.render(Routing(store) , document.querySelector("#root"));
