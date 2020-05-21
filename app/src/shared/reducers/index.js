import {combineReducers} from "redux"
import businessReducer from "./businessReducer";
// import userPostsReducer from "./user-posts-reducer"

export const combinedReducers = combineReducers({

	businesses: businessReducer,
// behaviors: userPostsReducer,
})


