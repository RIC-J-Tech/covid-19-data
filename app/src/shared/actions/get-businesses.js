import {httpConfig} from "../utils/http-config";

export const getAllBusinesses = () => async dispatch => {
	const {data} = await httpConfig('/apis/business/');
	dispatch({type: "GET_ALL_BUSINESSES", payload: data })
};

export const getBusinessByBusinessId =(id)=> async(dispatch) =>{

	const payload = await httpConfig.get(`/apis/business/${id}`)
	dispatch({type:"GET_BUSINESS_BY_BUSINESS_ID" ,payload: payload.data});

};

export const getBusinessByBusinessName =(businessName)=> async(dispatch) =>{

const payload = await httpConfig.get(`/apis/business/${businessName}`)
dispatch({type:"GET_BUSINESS_BY_BUSINESS_NAME" ,payload: payload.data});

};