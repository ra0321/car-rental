import React, {useEffect, useState}from 'react';
import { Button, DatePicker, Input } from "antd";
import { DownloadOutlined } from '@ant-design/icons';

import Table from './components/table';
import '../custom.css';
import moment from 'moment';
import jsPDF from "jspdf";
import "jspdf-autotable";
import * as FileSaver from 'file-saver';
import * as XLSX from 'xlsx';

const { RangePicker } = DatePicker;
const { Search } = Input;

const Trips = () => {
	const [reloadState, setReloadState] = useState(true);
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
	const reloadButton = () =>{
		setReloadState(s => !s);	
	}

	const getTableData=(data)=>{
		setTableData(data);
	}

	const fileType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8';
   	const fileExtension = '.xlsx';

    const exportToEXL = () => {
		 const data1 = tableData.map(item=> [
			item.trips_id,
			item.booking_date,
			item.start_date,
			item.end_date,
			item.status,
			item.trip_day,
			item.price_per_day
		]);
        const ws = XLSX.utils.json_to_sheet(data1);
        const wb = { Sheets: { 'data': ws }, SheetNames: ['data'] };
        const excelBuffer = XLSX.write(wb, { bookType: 'xlsx', type: 'array' });
        const data = new Blob([excelBuffer], {type: fileType});
        FileSaver.saveAs(data,  fileExtension);
    }

	const exportPDF = () => {
		const unit = "pt";
		const size = "A4"; // Use A1, A2, A3 or A4
		const orientation = "portrait"; // portrait or landscape
	
		const marginLeft = 40;
		const doc = new jsPDF(orientation, unit, size);
	
		doc.setFontSize(15);
	
		const title = "Cars List";
		const headers = [["TripID", "BookingDate","StartDate","EndDate","Status","TripDay","PricePerDay"]];
	
		const data = tableData.map(item=> [
			item.trips_id,
			item.booking_date,
			item.start_date,
			item.end_date,
			item.status,
			item.trip_day,
			item.price_per_day
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
				<Button onClick={reloadButton}>CARS LISTING</Button>
				<RangePicker
					onChange={date => setSelectDate(date)}
				/>
				<Search
					placeholder="input search text"
					onSearch={value => setSearchText(value)}
					style={{ width: 200 }}
				/>
			</div>
			<div className='DownBtn'>
				<Button type="default"   icon={<DownloadOutlined />}  >
					CSV
				</Button>
				<Button type="default"  icon={<DownloadOutlined />}  onClick={(e) => exportToEXL()}>
					EXCEL
				</Button>
				<Button type="default"  icon={<DownloadOutlined />} onClick={() =>exportPDF()}>
					PDF
				</Button>
			</div>
			<div>
				<Table startDate={startDate} getTableData={getTableData} searchText={searchText} endDate={endDate} reloadState={reloadState}/>
			</div>

		</React.Fragment>
	)
}

export default Trips
