import React, { Component } from 'react'

export class Icon extends Component {
	render() {
		const { type, className  } = this.props;
		return (
			<>{React.createElement(type, { className: className })}</>
		)
	}
}

export default Icon
