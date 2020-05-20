import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {Home} from "./pages/Home/Home";
import 'bootstrap/dist/css/bootstrap.css';
import thunk from "redux-thunk";
import {Provider} from "react-redux";
import {applyMiddleware, createStore} from "redux";
import reducers from "./shared/reducers";


const store = createStore(reducers,applyMiddleware(thunk));

const Routing = (store) => (
	<>
		<Provider store={store}>

		<BrowserRouter>
			<Switch>

				<Route exact path="/" component={Home}/>


			</Switch>
		</BrowserRouter>

		</Provider>
	</>
);
ReactDOM.render(Routing(store) , document.querySelector("#root"));