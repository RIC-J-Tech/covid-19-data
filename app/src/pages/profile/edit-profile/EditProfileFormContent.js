import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import React from "react";

export const EditProfileFormContent = (props) => {
	const {
		setFieldValue,
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
					<label htmlFor="profileEmail">Email Address</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<FontAwesomeIcon icon="envelope"/>
							</div>
						</div>
						<input
							className="form-control"
							name="profileEmail"
							type="email"
							value={values.profileEmail}
							placeholder="Enter email"
							onChange={handleChange}
							onBlur={handleBlur}

						/>
					</div>
					{
						errors.profileEmail && touched.profileEmail && (
							<div className="alert alert-danger">
								{errors.profileEmail}
							</div>
						)
					}
				</div>

				<div className="form-group">
					<label htmlFor="profileUsername">Username</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<FontAwesomeIcon icon="dove"/>
							</div>
						</div>
						<input
							className="form-control"
							name="profileUsername"
							type="text"
							value={values.profileUsername}
							placeholder="username"
							onChange={handleChange}
							onBlur={handleBlur}

						/>
					</div>
					{
						errors.profileUsername && touched.profileUsername && (
							<div className="alert alert-danger">
								{errors.profileUsername}
							</div>
						)
					}
				</div>

				<div className="form-group">
					<label htmlFor="profilePhone">Phone Number</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<FontAwesomeIcon icon="phone"/>
							</div>
						</div>
						<input
							className="form-control"
							id="profilePhone"
							type="text"
							value={values.profilePhone}
							placeholder="Phone no."
							onChange={handleChange}
							onBlur={handleBlur}

						/>
					</div>

					{
						errors.profilePhone && touched.profilePhone && (
							<div className="alert alert-danger">
								{errors.profilePhone}
							</div>
						)

					}
				</div>
				<div className="form-group">
					<button className="btn btn-primary mb-2" type="submit">Submit</button>
					<button
						className="btn btn-danger mb-2"
						onClick={handleReset}
						disabled={!dirty || isSubmitting}
					>Reset
					</button>
				</div>
				{/*<ImageDropZone*/}
				{/*	formikProps={{*/}
				{/*		values,*/}
				{/*		handleChange,*/}
				{/*		handleBlur,*/}
				{/*		setFieldValue,*/}
				{/*		fieldValue:"profileAvatarUrl"*/}
				{/*	}}*/}
				{/*/>*/}
				{status && (<div className={status.type}>{status.message}</div>)}

			</form>

			{
				status && (<div className={status.type}>{status.message}</div>)
			}
		</>


	)
};