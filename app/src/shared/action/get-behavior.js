import {httpConfig} from "../utils/http-config";

export const getAllTweets = () => async (dispatch) => {
	const payload =  await httpConfig.get("/apis/behavior/");
	dispatch({type: "GET_ALL_BEHAVIORS",payload : payload.data });
};