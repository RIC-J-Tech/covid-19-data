import * as Yup from "yup";
import {Formik} from "formik/dist/index";
import React from 'react';
import {httpConfig} from "../../utils/http-config";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";



export const VotePost = ({voteBehaviorId}) => {
	const votePost = {
		voteResult: ""

	};

	const validator = Yup.object().shape({
		behaviorContent: Yup.boolean()
			.required("Please post a behavior")

	});

	const submitVote = (values, {resetForm, setStatus}) => {
		const vote = {...values, voteBehaviorId}
		httpConfig.post("./apis/vote/", vote)
			.then(reply => {
					let {message, type} = reply;

					console.log(reply.data)

					if(reply.status === 200) {
						//TODO dispatch new Behavior
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
									<button className="btn btn-primary mb-2" type="submit">Post</button>
						</form>
					</>
				)
			}}
		</Formik>

	)
};