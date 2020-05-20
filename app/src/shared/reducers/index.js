import {combineReducers} from "redux"
import behaviorReducer from "./behavior-reducer"
import businessReducer from "./business-reducer"

export default combineReducers({
	business: businessReducer,
	posts: behaviorReducer,
})