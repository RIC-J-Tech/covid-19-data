import {combineReducers} from "redux"
import businessReducer from "./businessReducer";
import profileReducer from "./profileReducer";
import behaviorReducer from "./behaviorReducer";
import voteReducer from "./voteReducer";

export const combinedReducers = combineReducers({

	businesses: businessReducer,
	profiles: profileReducer,
	behaviors: behaviorReducer,
	votes: voteReducer,
})


