import React, {useEffect, useState}from 'react';
import { Button, DatePicker, Input } from "antd";
import { DownloadOutlined } from '@ant-design/icons';
import moment from 'moment';

import Table from './components/table';
import '../custom.css';
import jsPDF from "jspdf";
import "jspdf-autotable";
import * as FileSaver from 'file-saver';
import * as XLSX from 'xlsx';

const { RangePicker } = DatePicker;
const { Search } = Input;

const Earning = () => {
	const [selectDate, setSelectDate] = useState(null);
	const [startDate, setStartDate] = useState();
	const [endDate, setEndDate] = useState();
	const [searchText, setSearchText] = useState();
	const [tableData, setTableData]=useState([])

	useEffect(()=> {
		if(selectDate === null) {
			setStartDate("1900-01-01");
			setEndDate("2999-01-01");
		} else {
			setStartDate(moment(selectDate[0]).format("YYYY-MM-DD"));
			setEndDate(moment(selectDate[1]).format("YYYY-MM-DD"));
		}
	}, [selectDate]);
	const getTableData=(data)=>{
		setTableData(data);
	}

	const exportPDF = () => {
		const unit = "pt";
		const size = "A4"; // Use A1, A2, A3 or A4
		const orientation = "portrait"; // portrait or landscape
	
		const marginLeft = 40;
		const doc = new jsPDF(orientation, unit, size);
	
		doc.setFontSize(15);
	
		const title = "Cars List";
		const headers = [["ID", "BankName","Earnings","FirstName","LastName","iban","holder_name","penalty_amount","phone_number"]];
	
		const data = tableData.map(item=> [
			item.key,
			item.bank_name,
			item.earnings,
			item.first_name,
			item.last_name,
			item.iban,
			item.holder_name,
			item.penalty_amount,
			item.phone_number
		]);
	
		let content = {
		  startY: 50,
		  head: headers,
		  body: data
		};
	
		doc.text(title, marginLeft, 40);
		doc.autoTable(content);
		doc.save("report.pdf")
	  }

	return (
		<React.Fragment>
			<div className='CarBtn'>
				<Button type="default"  icon={<DownloadOutlined /> } onClick={() =>exportPDF()}>
					PDF
				</Button>
				{/* <RangePicker
					onChange={date => setSelectDate(date)}
				/>
				<Search
					placeholder="input search text"
					onSearch={value => setSearchText(value)}
					style={{ width: 200 }}
				/> */}
			</div>
			<div className='earning_table'>
				<Table startDate={startDate} endDate={endDate}  searchText={searchText} getTableData={getTableData}/>
			</div>

		</React.Fragment>
	)
}

export default Earning
