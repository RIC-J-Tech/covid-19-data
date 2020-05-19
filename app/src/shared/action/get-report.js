import {httpConfig} from "../utils/http-config";

export const getAllReports = () => async (dispatch) => {
	const payload =  await httpConfig.get("/apis/report/");
	dispatch({type: "GET_ALL_REPORTS",payload : payload.data });
};