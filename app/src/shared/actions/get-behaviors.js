import {httpConfig} from "../utils/http-config";

export const getAllBehaviors = () => async dispatch => {
	const {data} = await httpConfig('/apis/behavior/');
	dispatch({type: "GET_ALL_BEHAVIORS", payload: data })
};

export const getBehaviorByBehaviorProfileId =(behaviorProfileId)=> async(dispatch) =>{

	const payload = await httpConfig.get(`/apis/behavior/?behaviorProfileId=${behaviorProfileId}`)
	dispatch({type:"GET_BEHAVIOR_BY_BEHAVIOR_PROFILE_ID" ,payload: payload.data});

};

export const getBehaviorByBehaviorBusinessId =(behaviorBusinessId)=> async(dispatch) =>{

	const payload = await httpConfig.get(`/apis/behavior/?behaviorBusinessId=${behaviorBusinessId}`)
	dispatch({type:"GET_BEHAVIOR_BY_BEHAVIOR_BUSINESS_ID" ,payload: payload.data});

};


export const getBehaviorByBehaviorId =(id)=> async(dispatch) =>{

	const payload = await httpConfig.get(`/apis/behavior/${id}`)
	dispatch({type:"GET_BEHAVIOR_BY_BEHAVIOR_ID" ,payload: payload.data});

};

export const getBehaviorByBehaviorContent =(behaviorContent)=> async(dispatch) =>{

	const payload = await httpConfig.get(`/apis/behavior/?behaviorContent=${behaviorContent}`)
	dispatch({type:"GET_BEHAVIOR_BY_BEHAVIOR_CONTENT" ,payload: payload.data});

};