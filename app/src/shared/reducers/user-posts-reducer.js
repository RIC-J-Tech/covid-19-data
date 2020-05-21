export default (state = [], action) => {
	switch(action.type) {
		case "GET_ALL_BEHAVIORS":
			return action.payload;
		case "GET_BEHAVIOR_CONTENT":
			return action.payload;
		case "GET_BEHAVIOR_BY_BEHAVIOR_ID":
			return action.payload;

		case "GET_BEHAVIOR_BY_BEHAVIOR_PROFILE_ID":
			return action.payload;

		case "GET_BEHAVIOR_BY_BEHAVIOR_BUSINESS_ID":
			return action.payload
		default:
			return state;
	}
}