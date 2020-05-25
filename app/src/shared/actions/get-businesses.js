  
import {httpConfig} from "../utils/http-config";

export const getTopBusinesses = () => async dispatch => {
	const {data} = await httpConfig('/apis/business/?resultCount=3');
	dispatch({type: "GET_TOP_BUSINESSES", payload: data });
	
};

export const getBusinessByBusinessId =(id)=> async(dispatch) =>{

	const payload = await httpConfig.get(`/apis/business/${id}`)
	dispatch({type:"GET_BUSINESS_BY_BUSINESS_ID" ,payload: payload.data});
};

export const getBusinessesByBusinessName =(businessName)=> async(dispatch) =>{

const payload = await httpConfig.get(`/apis/business/?businessName=${businessName}`)
dispatch({type:"GET_BUSINESS_BY_BUSINESS_NAME" ,payload: payload.data});

};