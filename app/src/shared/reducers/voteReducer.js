export default (state = [], action) => {

	switch(action.type) {
		case "GET_ALL_VOTES":
			return action.payload;
		case "GET_VOTE_BY_VOTE_BUSINESS_ID":
			return [...state, action.payload];
		case "GET_VOTE_BY_VOTE_PROFILE_ID":
			return [...state, action.payload];
		case "GET_VOTE_BY_VOTE_BEHAVIOR_ID_AND_VOTE_PROFILE_ID":
			return [...state, action.payload];

		default:
			return state;
	}
}