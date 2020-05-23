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
// import {Image} from "./pages/image/Image"
import {MainNav} from "./shared/components/main-nav/MainNav";
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
import { BehaviorList } from './pages/behavior/BehaviorList';



const store = createStore(combinedReducers, applyMiddleware(thunk));

library.add(faStroopwafel, faEnvelope, faKey, faDove, faPhone);

const theme = createMuiTheme({
	palette: {
		primary:{light:'#33c9dc', main:'#00bcd4',dark:'#008394',contrastText:'#fff'},
		secondary:{light:'#ff633', main:'#ff3d00',dark:'#b22a00',contrastText:'#fff'}
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
					<Route exact path="/profile" component={Profile}/>
					<Route exact path="/business" component={Business}/>
					<Route exact path="/behavior" component={BehaviorList}/>

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

