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
import {Profile} from "./pages/profile/Profile";
import {MainNav} from "./shared/components/main-nav/MainNav"
import {BusinessPage} from "./pages/business/BusinessPage"


import { library } from '@fortawesome/fontawesome-svg-core'
import {faDove, faEnvelope, faKey, faPhone, faStroopwafel} from '@fortawesome/free-solid-svg-icons'
import {combinedReducers} from "./shared/reducers/index";

//MUI imports
import { ThemeProvider as MuiThemeProvider } from '@material-ui/core/styles';
// import MuiThemeProvider from '@material-ui/core/styles/MuiThemeProvider';
import createMuiTheme from '@material-ui/core/styles/createMuiTheme';
import grey from "@material-ui/core/colors/grey";
import {BusinessPAge} from "./pages/business/BusinessPage";



const store = createStore(combinedReducers, applyMiddleware(thunk));

library.add(faStroopwafel, faEnvelope, faKey, faDove, faPhone);

const theme = createMuiTheme({
	palette: {
		primary: {
			main: grey[800],
			contrastText: "#fff",
		},
		secondary: {
			main: grey[900],
			contrastText: "fff",
		},
	},
	typography:{
		useNextVariants: true
	}
});


const Routing = (store) => (
	<>
	
		<Provider store={store}>
		
			<MuiThemeProvider theme={theme}>
				<BrowserRouter>
				<MainNav/>
				<Switch>
					<Route exact path="/BusinessPage" component={BusinessPage}/>
					<Route exact path="/profile" component={Profile}/>
					<Route exact path="/" component={Home}/>
					<Route component={FourOhFour}/>
				</Switch>
					</BrowserRouter>
				</MuiThemeProvider>
		
		</Provider>
		
	</>
);

ReactDOM.render(Routing(store) , document.querySelector("#root"));

