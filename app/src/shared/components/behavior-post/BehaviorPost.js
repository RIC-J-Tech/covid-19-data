import * as Yup from "yup";
import {Formik} from "formik/dist/index";
import React from 'react';
import {httpConfig} from "../../utils/http-config";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {FormDebugger} from "../FormDebugger";
import {useDispatch} from "react-redux";
import {getAllBehaviors} from "../../actions/get-behaviors";
import { makeStyles } from '@material-ui/core/styles';
import TextField from '@material-ui/core/TextField';



export const BehaviorPost = ({behaviorBusinessId}) => {
	const behaviorPost = {
		behaviorContent: ""

	};
	 const dispatch = useDispatch();

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
						//TODO dispatch new Behavior
						dispatch(getAllBehaviors())

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
						<form onSubmit={handleSubmit} noValidate autoComplete="off">
							{/*controlId must match what is passed to the initialValues prop*/}
							<div className="form-group mt-5">
								<div className="input-group">
									<div className="input-group-prepend">
									
									</div>
									<TextField
										id="filled-multiline-flexible"
										label="Post a behavior"
										multiline
										rowsMax={4}
										value={values.behaviorContent}
										onChange={handleChange}
										onBlur={handleBlur}
										variant="filled"
										/>
									
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