export default (state = [], action) => {

	switch(action.type) {
		case "GET_ALL_BUSINESSES":
			return action.payload;
		case "GET_BUSINESS_BY_BUSINESS_ID":
			return [...action.payload];
		case "GET_BUSINESS_BY_BUSINESS_NAME":
<<<<<<< HEAD
			return  action.payload;
=======
			return [...state, ...action.payload];
>>>>>>> fixed behavior list to show
		default:
			return state;
	}
}