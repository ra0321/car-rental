import React from 'react';
import { Input, Upload, Modal, Checkbox, DatePicker, Space, Row, Col } from 'antd';
import { PlusOutlined } from '@ant-design/icons';
//import { usePlacesWidget } from "react-google-autocomplete";

import Autocomplete from "react-google-autocomplete";

function getBase64(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = error => reject(error);
  });
}

const options = [
  { label: 'GPS', value: 'gps' },
  { label: 'Child seat', value: 'child_seat' },
  { label: 'USB input', value: 'usb' },
  { label: 'Sunroof', value: 'sunroof' },
  { label: 'Bluetooth', value: 'bluetooth' },
  { label: 'Audio input', value: 'audio_input' },
  { label: 'All-wheel drive', value: 'all_drive' },
  { label: 'Heated seats', value: 'heated_seat' },
  { label: 'Bike rack', value: 'bike_rack' },
  { label: 'Ventilated seats', value: 'ventilated_seat' },
  { label: 'EV / Hybrid', value: 'hybrid' },
  { label: 'Pet friendly', value: 'pet_friendly' },
  { label: 'Convertible', value: 'convertible' },
  { label: 'Toll pass', value: 'toll_pass' },
  { label: 'Roof rack', value: 'ski_rack' },
];

function Customiz(props) {
  const { TextArea } = Input;
  const { RangePicker } = DatePicker;
  const [plateNumber, setplateNumber] = React.useState("");
  const [issueDate, setIssueDate] = React.useState("");
  const [expirationDate, setexpirationDate] = React.useState("");
  const [carDescription, setcarDescription] = React.useState("");
  const [previewVisible, setPreviewVisible] = React.useState(false);
  const [previewImage, setPreviewImage] = React.useState('');
  const [fileList, setFileList] = React.useState([]);
  const [carFeatures, setCarFeatures] = React.useState([]);
  const [city, setCity] = React.useState("");
  const [state, setState] = React.useState("");
  const [country, setCountry] = React.useState("");

  const uploadButton = (
    <div>
      <PlusOutlined />
      <div className="ant-upload-text">Add Car Image</div>
    </div>
  );

  const handleCancel = () => setPreviewVisible(false)

  const handlePreview = async file => {
    if (!file.url && !file.preview) {
      file.preview = await getBase64(file.originFileObj);
    }
    setPreviewImage(file.url || file.preview);
    setPreviewVisible(true);
  };

  const handleChange = ({ fileList }) => {
    console.log(fileList);
    setFileList([...fileList]);
  }

  const handleChangePlateNumber = (e) => {
    setplateNumber(e.target.value);
  }

  const handleChangeIssueDate = (date, dateString) => {
    setIssueDate(dateString);
  }

  const handleChangeExpirationDate = (date, dateString) => {
    setexpirationDate(dateString);
  }

  const handlechangeDescription = (e) => {
    setcarDescription(e.target.value);
  }

  function onChange(e) {
    const checkbox_value = e.target.value;
    if(!e.target.checked && carFeatures.indexOf(checkbox_value) > -1){
      carFeatures.splice(carFeatures.indexOf(checkbox_value), 1);
    }else if(e.target.checked && carFeatures.indexOf(checkbox_value) < 0){
      carFeatures.push(checkbox_value);
    }
    setCarFeatures(carFeatures);
  }

  const compIsType = (t, s) => { 
      for(let z = 0; z < t.length; ++z){
        if(t[z] == s)
          return true;
      }

      return false;
  }

  const handlePlaceChange = (place) => {
    console.log(place);
    if(place.address_components!==undefined){
      let addrComp = place.address_components;
      for(let i = 0; i < addrComp.length; ++i){
        var typ = addrComp[i].types;
        if(compIsType(typ, 'administrative_area_level_1')){
          setState(addrComp[i].long_name);
        }
        if(compIsType(typ, 'locality')){
          setCity(addrComp[i].long_name);
        }
        if(compIsType(typ, 'country')){
          setCountry(addrComp[i].long_name);
        }
      }
      
    }else{
      var address = place.formatted_address;
      if(address != undefined){
        const split_address = address.split(',');
        if(split_address[0] != undefined)
          setCity(split_address[0]);
        else
          setCity('');

        if(split_address[1] != undefined)
          setState(split_address[1]);
        else
          setState('');

        if(split_address[2] != undefined)
          setCountry(split_address[2]);
        else
          setCountry('');
      }
    }
  }

  React.useEffect(() => {
    if (plateNumber !== '' && issueDate !== '' && expirationDate !== ''
      || carDescription !== '' && fileList !== '' && carFeatures !== ''
      || city !== '' && state !== '' && country !== '') {
      let data = {
          country: country,
          state: state,
          city: city,
          licence_plate: plateNumber,
          expiration_date: expirationDate,
          date_of_issue: issueDate,
          carDescription: carDescription,
          carFeatures: carFeatures
      }

      if(fileList.length > 0){
        data.images = fileList[0].thumbUrl;
      }
      props.onSelectedValue(data);
    }
  }, [plateNumber, issueDate, expirationDate, carDescription, fileList, carFeatures, city, state, country]);

  /*const { ref, autocompleteRef } = usePlacesWidget({
    apiKey: 'AIzaSyA2vMx4B8g6zWCf3xYUxC40xePaunWQ6Tc',
    onPlaceSelected: (place) => {
      console.log("Selected Place");
      console.log(place);
    }
  });*/

  return (
    <>
      <h1>Detail</h1>
      <div className='customize_style'>
        <div className='customize_padding'>
          <div>
            License plate details
          </div>
          <div>
            <Input style={{ width: '200px' }} placeholder="Plate number" onChange={handleChangePlateNumber} value={plateNumber} />
          </div>
        </div>
        <div className='customize_padding'>
          <div>
            City,state,country
          </div>
          <div>
            <Autocomplete
              apiKey='AIzaSyA2vMx4B8g6zWCf3xYUxC40xePaunWQ6Tc'
              onPlaceSelected={handlePlaceChange}
              className="ant-input"
            />
          </div>
        </div>
      </div>
      <div className='customize_style'>
        <div className='customize_padding'>
          <div>
            Date of issue
          </div>
          <div>
            <Space direction="vertical" size={12}>
              <DatePicker renderExtraFooter={() => 'extra footer'} onChange={handleChangeIssueDate} />
            </Space>
          </div>
        </div>
        <div className='customize_padding'>
          <div>
            Expiration date
          </div>
          <div>
            <Space direction="vertical" size={12}>
              <DatePicker renderExtraFooter={() => 'extra footer'} onChange={handleChangeExpirationDate} />
            </Space>
          </div>
        </div>
      </div>
      <div className='upload_photo'>
        <div className='customize_padding'>
          <div>
            Upload photo of car registration
          </div>

          <div className="clearfix">
            <Upload
              beforeUpload={() => false}
              listType="picture-card"
              onPreview={handlePreview}
              onChange={handleChange}
            >
              {fileList.length >= 1 ? null : uploadButton}
            </Upload>
            <Modal visible={previewVisible} footer={null} onCancel={handleCancel}>
              <img alt="example" style={{ width: '100%' }} src={previewImage} />
            </Modal>
          </div>
        </div>
      </div>
      <div className='upload_photo'>
        <div className='customize_padding'>
          <h4>Car description</h4>
          <div className='upload_photo'>
            A detailed description will  help you get more trips
          </div>
          <TextArea rows={4} style={{ width: '750px' }} onChange={handlechangeDescription} />
          <div className='padding-top'>
            No need to includ your contact info; travels will receive  it once you've confirmed their trip.
          </div>
        </div>
      </div>
      <div className='upload_photo'>
        <div className='customize_padding'>
          <h3>
            Car features
          </h3>
          <div>
            <Row>
              { options.map((option, index) => (
                <Col span={8} key={option.value+1}>
                  <Checkbox onChange={onChange} key={option.value} value={option.value}> {option.label} </Checkbox>
                </Col>
              ))}
            </Row>
          </div>
        </div>
      </div>
    </>
  )
}

export default Customiz;