import {combineReducers} from "redux"
import businessReducer from "./businessReducer";
// import userPostsReducer from "./user-posts-reducer"

export default combineReducers({
	businesses: businessReducer,
	// behaviors: userPostsReducer,
})