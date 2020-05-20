export default (state = [], action) => {
	switch(action.type) {
		case "GET_BUSINESS_BY_BUSINESS_ID":
			return action.payload;
		case "GET_BUSINESS_BY_BUSINESS_NAME":
			return [...state, action.payload];
		default:
			return state;
	}
}