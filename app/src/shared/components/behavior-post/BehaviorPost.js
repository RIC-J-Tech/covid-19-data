import * as Yup from "yup";
import {Formik} from "formik/dist/index";
import React from 'react';
import {httpConfig} from "../../utils/http-config";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {useDispatch} from "react-redux";
import {getAllBehaviors} from "../../actions/get-behaviors";
import { TextField } from "@material-ui/core";
import { makeStyles } from '@material-ui/core/styles';

const useStyles = makeStyles((theme) => ({
		root: {
		  '& .MuiTextField-root': {
			margin: theme.spacing(1),
			width: '25ch',
		  },
		},
	  }));


export const BehaviorPost = ({behaviorBusinessId}) => {
	const classes = useStyles();
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
						<form  className={classes.root} onSubmit={handleSubmit}>
							{/*controlId must match what is passed to the initialValues prop*/}
									<div className="mt-5">

											<TextField
										className="form-control mt-5"
										id="behaviorContent"
										type="text"
										value={values.behaviorContent}
										placeholder="Post a behavior"
										onChange={handleChange}
										onBlur={handleBlur}
									/>
										<button className="btn btn-primary mt-5" type="submit">Post</button>
									</div>
						</form>

						{/*{status && (<div className={status.type}>{status.message}</div>)}*/}
					</>
				)
			}}
		</Formik>

	)
};