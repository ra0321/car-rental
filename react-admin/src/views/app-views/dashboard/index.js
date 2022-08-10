import React, { useState } from "react";
import { Row, Col, Button } from 'antd';
import StatisticWidget from 'components/shared-components/StatisticWidget';
import { AnnualStatisticData ,AnnualStatisticData1} from './DefaultDashboardData';

const Dashboard = () => {
	const [annualStatisticData] = useState(AnnualStatisticData);
	const [annualStatisticData1] = useState(AnnualStatisticData1);
	const handleCount = () => {
		console.log("this is counts");
	}
	return (
		<>
			<Row gutter={16}>
			{
				annualStatisticData.map((elm, i) => (
				<Col xs={8} sm={8} md={8} lg={8} xl={8} key={i}>
					<StatisticWidget 
					title={elm.title} 
					value={elm.value}
					extra={<Button type="default" onClick={handleCount}>COUNTS</Button>}
					/>
				</Col>
				))
			}
			</Row>
			<Row gutter={16}>
			{
				annualStatisticData1.map((elm, i) => (
				<Col xs={8} sm={8} md={8} lg={8} xl={8} key={i}>
					<StatisticWidget 
					title={elm.title} 
					value={elm.value}
					/>
				</Col>
				))
			}
			</Row>
		</>
		
	)
}

export default Dashboard
