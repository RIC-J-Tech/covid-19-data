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
import {RussHome} from "./pages/home/RussHome";
import {TestProfile} from "./pages/profile/TestProfile";
// import {Image} from "./pages/image/Image"
// import {NavTest} from "./shared/components/main-nav/NavTest";
import {MainNav} from "./shared/components/main-nav/MainNav"
import {Business} from "./pages/business/Business"


//components
//pages
//

import { library } from '@fortawesome/fontawesome-svg-core'
import {faDove, faEnvelope, faKey, faPhone, faStroopwafel} from '@fortawesome/free-solid-svg-icons'
import {combinedReducers} from "./shared/reducers/index";
import {BusinessList} from "./pages/business/BusinessList";

//MUI imports
import { ThemeProvider as MuiThemeProvider } from '@material-ui/core/styles';
// import MuiThemeProvider from '@material-ui/core/styles/MuiThemeProvider';
import createMuiTheme from '@material-ui/core/styles/createMuiTheme';
import grey from "@material-ui/core/colors/grey";



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
					<Route exact path="/profile" component={TestProfile}/>
					<Route exact path="/business" component={Business}/>

					{/*<Route exact path="/image" component={Image}/>*/}
					<Route exact path="/" component={Home}/>
					<Route component={FourOhFour}/>
				</Switch>
					</BrowserRouter>
				</MuiThemeProvider>
		
		</Provider>
		
	</>
);

ReactDOM.render(Routing(store) , document.querySelector("#root"));

