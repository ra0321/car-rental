import moment from 'moment';
import React, {useEffect, useState}from 'react';
import { Button, DatePicker, Input } from "antd";
import { DownloadOutlined } from '@ant-design/icons';
import jsPDF from "jspdf";
import "jspdf-autotable";
import * as FileSaver from 'file-saver';
import * as XLSX from 'xlsx';

import Table from './components/table';
import '../custom.css';

const { RangePicker } = DatePicker;
const { Search } = Input;
const Cars =  () => {
	const [selectDate, setSelectDate] = useState(null);
	const [startDate, setStartDate] = useState();
	const [endDate, setEndDate] = useState();
	const [searchText, setSearchText] = useState();
	const [reloadState, setReloadState] = useState(true);
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
	//download pdf
	const exportPDF = () => {
		const unit = "pt";
		const size = "A4"; // Use A1, A2, A3 or A4
		const orientation = "portrait"; // portrait or landscape
	
		const marginLeft = 40;
		const doc = new jsPDF(orientation, unit, size);
	
		doc.setFontSize(15);
	
		const title = "Cars List";
		const headers = [["CARDID", "Manufactuer","Model","Year","City","Active","OwnerId","OwnerName","CreatedOn"]];
	
		const data = tableData.map(item=> [
			item.key,
			item.car_manufacturer, 
			item.car_model,
			item.production_year,
			item.car_city,
			item.active,
			item.owner_id,
			item.owner_name,
			item.created_at,
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

	//download xlsx
	const fileType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=UTF-8';
   	const fileExtension = '.xlsx';

    const exportToEXL = () => {
		 const data1 = tableData.map(item=> [
			item.key,
			item.car_manufacturer, 
			item.car_model,
			item.production_year,
			item.car_city,
			item.active,
			item.owner_id,
			item.owner_name,
			item.created_at,
		]);
        const ws = XLSX.utils.json_to_sheet(data1);
        const wb = { Sheets: { 'data': ws }, SheetNames: ['data'] };
        const excelBuffer = XLSX.write(wb, { bookType: 'xlsx', type: 'array' });
        const data = new Blob([excelBuffer], {type: fileType});
        FileSaver.saveAs(data,  fileExtension);
    }
	//download csv


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
				<Button type="default"  icon={<DownloadOutlined /> } onClick={(e) => exportToEXL()}>
					EXCEL
				</Button>
				<Button type="default"  icon={<DownloadOutlined />} onClick={() =>exportPDF()}>
					PDF
				</Button>
			</div>
			<div>
				<Table startDate={startDate} endDate={endDate} searchText={searchText} reloadState={reloadState} getTableData={getTableData}/>
			</div>

		</React.Fragment>
	)
}

export default Cars
