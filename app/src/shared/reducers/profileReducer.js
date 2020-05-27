export default (state = [], action) => {

	switch(action.type) {
		case "GET_ALL_PROFILES":
			return action.payload;
		case "GET_PROFILE_BY_PROFILE_ID":
			return action.payload;
		case "GET_PROFILE_BY_USERNAME":
			return [...state, action.payload];
		case "GET_PROFILE_BY_EMAIL":
			return [...state, action.payload]
		default:
			return state;
	}
}