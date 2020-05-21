import {combineReducers} from "redux"
import userReducer from "./user-reducer";
// import userPostsReducer from "./user-posts-reducer"

export default combineReducers({
	businesses: userReducer,
	// behaviors: userPostsReducer,
})