import React, {useState} from 'react';
import {httpConfig} from "../../utils/http-config";
import * as Yup from "yup";
import {Formik} from "formik/dist/index";

import {ProfileFormContent} from "./ProfileFormContent";

export const ProfileForm = (profileData) => {
	// const profileData = profile;

	const validator = Yup.object().shape({
		profileEmail: Yup.string()
			.email("email must be a valid email")
			.required('email is required'),
		profileUsername: Yup.string()
			.required("profile handle is required"),
		profilePassword: Yup.string()
			.required("Password is required")
			.min(8, "Password must be at least eight characters"),
		profilePasswordConfirm: Yup.string()
			.required("Password Confirm is required")
			.min(8, "Password must be at least eight characters"),
		profilePhone: Yup.string()
			.min(10, "phone number is to short")
			.max(10, "phone Number is to long")
	});

	const submitProfileEdit = (values, {resetForm, setStatus}) => {
		httpConfig.post("./apis/profile/", values)
			.then(reply => {
					let {message, type} = reply;

					console.log(reply.data)

					if(reply.status === 200) {
						resetForm();

						alert("You have successfully edited your account!")
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
			initialValues={profileData}
			onSubmit={submitProfileEdit}
			validationSchema={validator}
		>
			{ProfileFormContent}
		</Formik>

	)
};