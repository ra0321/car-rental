import React from 'react'
import PropTypes from 'prop-types'

const Flex = props => {
	const { children, className, alignItems, justifyContent, mobileFlex, flexDirection } = props
	const getFlexResponsive = () => mobileFlex ? 'd-flex' : 'd-md-flex'
	return (
		<div className={`${getFlexResponsive()} ${className} ${flexDirection?('flex-' + flexDirection): ''} ${alignItems?('align-items-' + alignItems):''} ${justifyContent?('justify-content-' + justifyContent):''}` }>
			{children}
		</div>
	)
}

Flex.propTypes = {
	className: PropTypes.string,
	alignItems: PropTypes.string,
	flexDirection: PropTypes.string,
	justifyContent: PropTypes.string,
	mobileFlex: PropTypes.bool
}

Flex.defaultProps = {
	mobileFlex: true,
	flexDirection: 'row',
	className: ''
};


export default Flex
