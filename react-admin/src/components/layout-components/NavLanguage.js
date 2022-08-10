import React from "react";
import { CheckOutlined, GlobalOutlined, DownOutlined  } from '@ant-design/icons';
import { Menu, Dropdown } from "antd";
import lang from "assets/data/language.data.json";
import { connect } from "react-redux";
import { onLocaleChange } from 'redux/actions/Theme'

function getLanguageDetail (locale) {
	const data = lang.filter(elm => (elm.langId === locale))
	return data[0]
}

const SelectedLanguage = ({ locale }) => {
	const language = getLanguageDetail(locale)
	const {langName, icon} = language
	return (
		<div className="d-flex align-items-center">
			<img style={{maxWidth: '20px'}} src={`/img/flags/${icon}.png`} alt={langName}/>
			<span className="font-weight-semibold ml-2">{langName} <DownOutlined className="font-size-xs"/></span>
		</div>
	)
}

export const NavLanguage = ({ locale, configDisplay, onLocaleChange }) => {
	const languageOption = (
		<Menu>
			{
				lang.map((elm, i) => {return (
					<Menu.Item 
						key={i} 
						className={locale === elm.langId? 'ant-dropdown-menu-item-active': ''} 
						onClick={() => onLocaleChange(elm.langId)}
					>
						<span className="d-flex justify-content-between align-items-center">
							<div>
								<img style={{maxWidth: '20px'}} src={`/img/flags/${elm.icon}.png`} alt={elm.langName}/>
								<span className="font-weight-normal ml-2">{elm.langName}</span>
							</div>
							{locale === elm.langId? <CheckOutlined className="text-success" /> : null}
						</span>
					</Menu.Item>
				)})
			}
		</Menu>
	)
	return (
		<Dropdown placement="bottomRight" overlay={languageOption} trigger={["click"]}>
			{
				configDisplay ?
				(
					<a href="#/" className="text-gray" onClick={e => e.preventDefault()}>
						<SelectedLanguage locale={locale}/>
					</a>
				)
				:
				(
					<Menu mode="horizontal">
						<Menu.Item key="language">
							<a href="#/" onClick={e => e.preventDefault()}>
								<GlobalOutlined className="nav-icon mr-0" />
							</a>
						</Menu.Item>
					</Menu>
				)
			}
		</Dropdown>
	)
}

const mapStateToProps = ({ theme }) => {
  const { locale } =  theme;
  return { locale }
};

export default connect(mapStateToProps, {onLocaleChange})(NavLanguage);
