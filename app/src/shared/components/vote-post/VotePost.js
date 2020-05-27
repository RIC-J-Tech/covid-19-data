import * as Yup from "yup";
import {Formik} from "formik/dist/index";
import React from 'react';
import {httpConfig} from "../../utils/http-config";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import * as jwtDecode from "jwt-decode";



export const VotePost = ({voteBehaviorId}) => {
	let loggedInUser =
		window.localStorage.getItem("jwt-token") !== null
			? jwtDecode(window.localStorage.getItem("jwt-token")).auth.profileId
			: "none";
console.log(window.localStorage.getItem("jwt-token"))
	const votePost = {
		voteResult: "1",
		voteBehaviorId: voteBehaviorId,
		voteProfileId: loggedInUser
	};


	// if(loggedInUser)

	const validator = Yup.object().shape({
		behaviorContent: Yup.string()

	});

	 
	const headers = {
		"X-JWT-TOKEN": window.localStorage.getItem("jwt-token")
	  };

	const submitVote = (values, {resetForm, setStatus}) => {
		const vote = {...values, voteBehaviorId}
		httpConfig.post("./apis/vote/", vote,{headers:headers})
			.then(reply => {
					let {message, type} = reply;
					console.log(reply.data)

					if(reply.status === 200) {
						//TODO dispatch new Behavior
						resetForm();
					}
					setStatus({message, type});
				}
			);
	};


	return (

		<Formik
			initialValues={votePost}
			onSubmit={submitVote}
			validationSchema={validator}
		>
			{ (props)=> {
				const {
					status,
					values,
					errors,
					touched,
					dirty,
					isSubmitting,
					handleChange,
					handleBlur,
					handleSubmit,
					handleReset
				} = props;
				return (
					<>
						<form onSubmit={handleSubmit}>
									<button className="btn btn-primary mb-2" type="submit">Vote</button>
						</form>
					</>
				)
			}}
		</Formik>

	)
};