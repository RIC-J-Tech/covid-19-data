import {combineReducers} from "redux"
import behaviorReducer from "./behavior-reducer"
import businessReducer from "./business-reducer"

export default combineReducers({
	businesses: businessReducer,
	behaviors: behaviorReducer,
})