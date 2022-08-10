import React from 'react'
import PropTypes from 'prop-types'
import { Card, Progress } from 'antd';

export const GoalWidget = ({ title, value, size, subtitle, strokeWidth, extra }) => {
	return (
		<Card>
			<div className="text-center">
				{title && <h4 className="mb-3 font-weight-bold">{title}</h4>}
				<Progress type="dashboard" percent={value} width={size} strokeWidth={strokeWidth}/>
				<div className={`mt-2 mx-auto text-muted ${extra ? 'mb-3' : ''}`} style={{maxWidth: `${size + 30}px`}}>
					{subtitle}
				</div>
				{extra}
			</div>
		</Card>
	)
}

GoalWidget.propTypes = {
	title: PropTypes.oneOfType([
		PropTypes.string,
		PropTypes.element
	]),
	value: PropTypes.number,
	size: PropTypes.number,
	subtitle: PropTypes.string,
	extra:PropTypes.oneOfType([
		PropTypes.string,
		PropTypes.element
	])
}

GoalWidget.defaultProps = {
	strokeWidth: 4,
	size: 150
};

export default GoalWidget
