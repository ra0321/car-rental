import React from 'react'
import { Card } from 'antd';
import PropTypes from "prop-types";
import { ArrowUpOutlined, ArrowDownOutlined } from '@ant-design/icons';

const StatisticWidget = ({ title, value, status, subtitle, prefix, extra }) => {
	return (
		<Card style={{justifyContent: 'center', display: 'flex'}} hoverable bordered>
			{title && <h4 className="mb-0">{title}</h4>}
			<div className={`${prefix? 'd-flex': ''} ${title ? 'mt-3':''}`}>
				{prefix ? <div className="mr-2">{prefix}</div> : null}
				<div>
					<div className="d-flex align-items-center">
						<h1 className="mb-0 font-weight-bold">{value}</h1>
						{
							status ? 
							<span className={`font-size-md font-weight-bold ml-3 ${status !== 0 && status > 0 ? 'text-success' : 'text-danger'}`} >
								{status}
								{status !== 0 && status > 0 ? <ArrowUpOutlined /> : <ArrowDownOutlined />}
							</span> 
							: 
							null
						}
					</div>
					{subtitle && <div className="text-gray-light mt-1">{subtitle}</div>}
					{extra}
				</div>
			</div>
		</Card>
	)
}

StatisticWidget.propTypes = {
  	title: PropTypes.oneOfType([
		PropTypes.string,
		PropTypes.element
	]),
	value: PropTypes.string,
	subtitle: PropTypes.string,
	status: PropTypes.number,
	prefix: PropTypes.element,
	extra:PropTypes.oneOfType([
		PropTypes.string,
		PropTypes.element
	])
};

export default StatisticWidget