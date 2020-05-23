import * as Yup from "yup";
import {Formik} from "formik/dist/index";
import React from 'react';
import {httpConfig} from "../../utils/http-config";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {FormDebugger} from "../FormDebugger";


export const BehaviorPost = ({behaviorBusinessId}) => {
	const behaviorPost = {
		behaviorContent: ""

	};

	const validator = Yup.object().shape({
		behaviorContent: Yup.string()
			.required("Please post a behavior")
			.max(140),

	});

	const submitPost = (values, {resetForm, setStatus}) => {
		const behavior = {...values, behaviorBusinessId}
		httpConfig.post("./apis/behavior/", behavior)
			.then(reply => {
					let {message, type} = reply;

					console.log(reply.data)

					if(reply.status === 200) {
						resetForm();

						alert("You have successfully posted a behavior!")
					}

					else {
						alert("Not sure what happened!")
					}

					setStatus({message, type});
				}
			);
	};


	return (

		<Formik
			initialValues={behaviorPost}
			onSubmit={submitPost}
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
							{/*controlId must match what is passed to the initialValues prop*/}
							<div className="form-group">
								<label htmlFor="behaviorPost">Post Behavior</label>
								<div className="input-group">
									<div className="input-group-prepend">
										<div className="input-group-text">
											<FontAwesomeIcon icon="envelope"/>
										</div>
									</div>
									<input
										className="form-control"
										id="behaviorContent"
										type="text"
										value={values.behaviorContent}
										placeholder="Post a behavior"
										onChange={handleChange}
										onBlur={handleBlur}

									/>
										<button className="btn btn-primary mb-2" type="submit">Post</button>
								</div>

							</div>
							{/*<FormDebugger {...props} />*/}
						</form>

						{/*{status && (<div className={status.type}>{status.message}</div>)}*/}
					</>
				)
			}}
		</Formik>

	)
};