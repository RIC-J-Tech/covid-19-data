import React from "react";
import {BusinessNameFooter} from "./BusinessNameFooter";

export const  PostCard = ({post}) => {

	return (
		<div className="card text-white bg-dark mb-3">
			<div className="card-body">
				<h5 className="card-title">{post.title}</h5>
				<p className="card-text">{post.body}</p>
				<p className="card-text">
					<small className="text-muted">{post.businessName}</small>
				</p>
				<div className="card-footer text-muted text-center">
					<BusinessNameFooter businessId={post} Id={post.postBusinessId}/>
				</div>
			</div>
		</div>
	)
};