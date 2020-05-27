import React from "react";
import Form from "react-bootstrap/Form";
import {useDispatch} from "react-redux";
import {getBusinessesByBusinessName} from "../../actions/get-businesses";

// import FormControl from "react-bootstrap/FormControl";

export const SearchFormContent = (props) => {
const dispatch = useDispatch()
const [searchWord, setSearchWord] = React.useState();
const searchEffect  = ()=>{
	searchWord !== undefined && dispatch(getBusinessesByBusinessName(searchWord))
};
React.useEffect(searchEffect,[searchWord]);
	const setSearch = (event) => {
		event.preventDefault();
		console.log(searchWord)
		//check the input field for which characters are being entered and set them as the search term
		setSearchWord(event.target.value);
	};


	return (
		<>
			<container>
			<Form inline className="justify-content-end">
				<Form.Control type="text"
								  placeholder="Search for businesses... "
								  id="search-text"
								  onChange={setSearch}
								  // value={searchWord}

				/>
				<button type="submit" class="btn btn-primary">Search</button>
			</Form>
			</container>
		</>

	);
};