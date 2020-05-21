import React from 'react';
import classname from 'classname';
class FlashMessage extends React.Component {
	render() {
		const { id, type, text } = this.props.message;
		return (
			<div className={classnames('alert', {
				'alert-success': type === 'success',
				'alert-danger': type === 'error'
			})}>
				{text}
			</div>
		);
	}
}
FlashMessage.prototype = {
	message: React.PropTypes.object.isRequired
}
export default FlashMessage;