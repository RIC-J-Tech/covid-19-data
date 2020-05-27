  
import {httpConfig} from "../utils/http-config";

export const getAllProfiles = () => async dispatch => {
	const {data} = await httpConfig('/apis/profile/');
	dispatch({type: "GET_ALL_PROFILES", payload: data })
};

export const getProfileByProfileId =(id)=> async(dispatch) =>{

	const payload = await httpConfig.get(`/apis/profile/${id}`)
	dispatch({type:"GET_PROFILE_BY_PROFILE_ID" ,payload: payload.data});

};

export const getProfileByUsername =(profileUsername)=> async(dispatch) =>{

	const payload = await httpConfig.get(`/apis/profile/?profileUsername=${profileUsername}`)
	dispatch({type:"GET_PROFILE_BY_USERNAME" ,payload: payload.data});

};

export const getProfileByEmail =(profileEmail)=> async(dispatch) =>{

	const payload = await httpConfig.get(`/apis/profile/?profileEmail=${profileEmail}`)
	dispatch({type:"GET_PROFILE_BY_EMAIL" ,payload: payload.data});

};