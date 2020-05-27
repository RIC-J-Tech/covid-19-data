import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import React from "react";

export const ProfileFormContent = (props) => {
	const {
		submitStatus,
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
							id="profileEmail"
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
				{/*controlId must match what is defined by the initialValues object*/}
				<div className="form-group">
					<label htmlFor="profilePassword">Password</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<FontAwesomeIcon icon="key"/>
							</div>
						</div>
						<input
							id="profilePassword"
							className="form-control"
							type="password"
							placeholder="Password"
							value={values.profilePassword}
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{errors.profilePassword && touched.profilePassword && (
						<div className="alert alert-danger">{errors.profilePassword}</div>
					)}
				</div>
				<div className="form-group">
					<label htmlFor="profilePasswordConfirm">Confirm Your Password</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<FontAwesomeIcon icon="key"/>
							</div>
						</div>
						<input

							className="form-control"
							type="password"
							id="profilePasswordConfirm"
							placeholder="Password Confirm"
							value={values.profilePasswordConfirm}
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{errors.profilePasswordConfirm && touched.profilePasswordConfirm && (
						<div className="alert alert-danger">{errors.profilePasswordConfirm}</div>
					)}
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
							id="profileUsername"
							type="text"
							value={values.profileUsername}
							placeholder="Username"
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
							placeholder="Enter Phone number"
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
					<label htmlFor="profileAvatarUrl">Avatar Image Url</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<FontAwesomeIcon icon="upload"/>
							</div>
						</div>
						<input
							className="form-control"
							id="profileAvatarUrl"
							type="text"
							value={values.profileAvatarUrl}
							placeholder="Enter Avatar Url"
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{/*{*/}
					{/*	errors.profilePhone && touched.profilePhone && (*/}
					{/*		<div className="alert alert-danger">*/}
					{/*			{errors.profilePhone}*/}
					{/*		</div>*/}
					{/*	)*/}

					{/*}*/}
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

			</form>

			{/*{status && (<div className={status.type}>{status.message}</div>)}*/}
		</>


	)
};