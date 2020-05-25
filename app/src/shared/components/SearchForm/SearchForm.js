import React from "react";
import Form from "react-bootstrap/Form";

// import FormControl from "react-bootstrap/FormControl";

export const SearchFormContent = ({setSearchWord}) => {
		 const setSearch = (event) => {
		 	event.preventDefault();
		 	//check the input field for which characters are being entered and set them as the search term
		 	setSearchWord(event.target.value);
};

	return (
		<>
			<Form inline className="justify-content-center p-5">
				<Form.Control type="text"
					    placeholder="Search for recipe... "
                        id="search-text"
                        onChange={setSearch} 
						 
				/>	
                <button type="submit" class="btn btn-primary" onSubmit={setSearch}>Search</button>
			</Form>
        </>
	);
};