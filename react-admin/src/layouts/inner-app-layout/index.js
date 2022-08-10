import React, { useState } from 'react'
import PropTypes from "prop-types";
import { Grid, Drawer } from "antd";
import utils from 'utils'
import { MenuOutlined } from '@ant-design/icons';

const { useBreakpoint } = Grid;

const SideContent = props => {
	const { sideContent, sideContentWidth = 250, border } = props
	return (
		<div className={`side-content ${border? 'with-border': ''}`} style={{width: `${sideContentWidth}px`}}>
			{sideContent}
		</div>
	)
}

const SideContentMobile = props => {
	const { sideContent, visible, onSideContentClose } = props
	return (
		<Drawer
			width={320}
			placement="left"
			closable={false}
			onClose={onSideContentClose}
			visible={visible}
			bodyStyle={{paddingLeft: 0, paddingRight: 0}}
		>
			<div className="h-100">
				{sideContent}
			</div>
		</Drawer>
	)
}

export const InnerAppLayout = props => {
	const { mainContent, pageHeader, sideContentGutter = true } = props
	const isMobile = !utils.getBreakPoint(useBreakpoint()).includes('lg')
	const [visible, setVisible] = useState(false);

	const close = (e) => {
		setVisible(false)
	} 

	const openSideContentMobile = () => {
		setVisible(true)
	}

	return (
		<div className="inner-app-layout">
			{isMobile ? 
				<SideContentMobile 
					visible={visible} 
					onSideContentClose={close}
					{...props}
				/> 
				: 
				<SideContent {...props} />
			}
			<div className={`main-content ${pageHeader? 'has-page-header' : ''} ${sideContentGutter? 'gutter' : 'no-gutter'}`}>
				{isMobile ? 
					<div className={`font-size-lg mb-3 ${!sideContentGutter ? 'pt-3 px-3' : ''}`}>
						<MenuOutlined onClick={() => openSideContentMobile()}/>
					</div>
					:
					null
				}
				{mainContent}
			</div>
		</div>
	)
}

InnerAppLayout.propTypes = {
	sideContent: PropTypes.node,
	mainContent: PropTypes.node,
	pageHeader: PropTypes.bool,
	sideContentWidth: PropTypes.number,
	border: PropTypes.bool,
	sideContentGutter: PropTypes.bool
};

export default InnerAppLayout
