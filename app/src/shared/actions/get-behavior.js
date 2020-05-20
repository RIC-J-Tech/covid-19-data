import {httpConfig} from "../utils/http-config";

export const getAllBehaviors = () => async (dispatch) => {
	const payload =  await httpConfig.get("/apis/behavior/");
	dispatch({type: "GET_ALL_BEHAVIORS",payload : payload.data });
};

//Get payload from behavior Id
export const getBehaviorByBehaviorId =(id)=> async (dispatch) => {
	const payload = await httpConfig.get(`/apis/behavior/${Id}`)
	dispatch({type: "GET_BEHAVIOR_BY_BEHAVIOR_ID", payload : payload.data});

};


export const getBehaviorByBehaviorProfileId =()=> async (dispatch) => {
	const payload = await httpConfig.get(`/apis/behavior/${behaviorProfileId}`)
	dispatch({type: "GET_BEHAVIOR_BY_BEHAVIOR_PROFILE_ID", payload : payload.data});

};

export const getBehaviorByBehaviorBusinessId =()=> async (dispatch)=>{
	const payload = await httpConfig.get(`/apis/behavior/${behaviorBusinessId}`)
	dispatch({type: "GET_BEHAVIOR_BY_BEHAVIOR_BUSINESS_ID", payload : payload.data});

};

