import React from 'react'
import { Dropdown, Menu } from 'antd';
import { EllipsisOutlined } from '@ant-design/icons';
import PropTypes from 'prop-types'

const EllipsisDropdown = props => {
	return (
		<Dropdown overlay={props.menu} placement={props.placement} trigger={['click']}>
			<div className="ellipsis-dropdown">
				<EllipsisOutlined />
			</div>
		</Dropdown>
	)
}

EllipsisDropdown.propTypes = {
	trigger: PropTypes.string,
	placement: PropTypes.string
}

EllipsisDropdown.defaultProps = {
	trigger: 'click',
	placement: 'bottomRight',
	menu: <Menu/>
};

export default EllipsisDropdown
