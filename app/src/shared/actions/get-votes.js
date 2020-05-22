import {httpConfig} from "../utils/http-config";

export const getAllVotes = () => async dispatch => {
	const {data} = await httpConfig('/apis/vote/');
	dispatch({type: "GET_ALL_VOTES", payload: data })
};

export const getVoteByVoteProfileId =(voteProfileId)=> async(dispatch) =>{

	const payload = await httpConfig.get(`/apis/vote/?voteProfileId=${voteProfileId}`)
	dispatch({type:"GET_VOTE_BY_VOTE_PROFILE_ID" ,payload: payload.data});

};

export const getVoteByVoteBusinessId =(voteBusinessId)=> async(dispatch) =>{

	const payload = await httpConfig.get(`/apis/vote/?voteBusinessId=${voteBusinessId}`)
	dispatch({type:"GET_VOTE_BY_VOTE_BUSINESS_ID" ,payload: payload.data});

};


export const getVoteByVoteBehaviorIdAndVoteProfileId =(id)=> async(dispatch) =>{

	const payload = await httpConfig.get(`/apis/vote/${id}`)
	dispatch({type:"GET_VOTE_BY_VOTE_BEHAVIOR_ID_AND_VOTE_PROFILE_ID" ,payload: payload.data});

};


