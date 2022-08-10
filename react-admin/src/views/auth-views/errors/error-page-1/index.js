import React from 'react'
import { Button, Row, Col } from "antd";
import { ArrowLeftOutlined } from '@ant-design/icons';
import { APP_NAME } from 'configs/AppConfig';
import { Link } from 'react-router-dom';
import Flex from 'components/shared-components/Flex';
import { useSelector } from 'react-redux';

const ErrorOne = () => {
	const theme = useSelector(state => state.theme.currentTheme)
	return (
		<div className={`h-100 ${theme === 'light' ? 'bg-white' : ''}`}>
			<div className="container-fluid d-flex flex-column justify-content-between h-100 px-md-4 pb-md-4 pt-md-1">
				<div>
					<img className="img-fluid" src={`/img/${theme === 'light' ? 'logo.png': 'logo-white.png'}`} alt="" />
				</div>
				<div className="container">
					<Row align="middle">
						<Col xs={24} sm={24} md={8}>
							<h1 className="font-weight-bold mb-4 display-4">Page not found</h1>
							<p className="font-size-md mb-4">We've noticed you lost your way, no worries, we will help you to found the correct path.</p>
							<Link to='/app'>
								<Button type="primary" icon={<ArrowLeftOutlined />}>Go back</Button>
							</Link>
						</Col>
						<Col xs={24} sm={24} md={{ span: 14, offset: 2 }}>
							<img className="img-fluid mt-md-0 mt-4" src="/img/others/img-20.png" alt="" />
						</Col>
					</Row>
				</div>
				<Flex mobileFlex={false} justifyContent="between">
					<span>Copyright  &copy;  {`${new Date().getFullYear()}`} <span className="font-weight-semibold">{`${APP_NAME}`}</span></span>
					<div>
						<a className="text-gray" href="/#" onClick={e => e.preventDefault()}>Term & Conditions</a>
						<span className="mx-2 text-muted"> | </span>
						<a className="text-gray" href="/#" onClick={e => e.preventDefault()}>Privacy & Policy</a>
					</div>
				</Flex>
			</div>
		</div>
	)
}

export default ErrorOne
