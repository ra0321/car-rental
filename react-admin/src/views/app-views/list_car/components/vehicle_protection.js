import React, {useEffect, useState} from 'react';
import { Select, Input, Upload, Modal, DatePicker, Space  } from 'antd';
import { PlusOutlined } from '@ant-design/icons';

function getBase64(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = error => reject(error);
  });
}

function VehicleProtection(props) {
  const [previewVisible, setPreviewVisible] = useState(false);
  const [previewImage, setPreviewImage] = useState('');
  const [issueDate, setIssueDate] = useState("");
  const [expirationDate, setexpirationDate] = useState("");
  const [detectableAmount, setDetectableAmount] = useState("");
  const [policyNumber, setPolicyNumber] = useState("");
  const [fileList, setFileList] = useState([]);

  const uploadButton = (
    <div>
      <PlusOutlined />
      <div className="ant-upload-text">Add Image</div>
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
    setFileList([ ...fileList ]);
  }

  const handleChangeDetectableAmount = (e) => {
    setDetectableAmount(e.target.value);
  }

  const handleChangePolicyNumber = (e) => {
    setPolicyNumber(e.target.value);
  }

  const handleChangeIssueDate = (date, dateString) => {
    setIssueDate(dateString);
  }

  const handleChangeExpirationDate = (date, dateString) => {
    setexpirationDate(dateString);
  }

  useEffect(() => {
    if (issueDate !== '' && expirationDate !== '' && detectableAmount !== ''
      || policyNumber !== '' && fileList !== '') {
      let data = {
        policy_number: policyNumber,
        detectable_amount: detectableAmount,
        expiration_date: expirationDate,
        date_of_issue: issueDate,
      }
      if(fileList.length > 0){
        data.images = fileList[0].thumbUrl;
        //console.log(data);
      }
      props.onSelectedValue(data);
    }
  },[issueDate, expirationDate, detectableAmount, policyNumber, fileList])

  return (
    <>
      <h1>Detail</h1>
      <div className='customize_style'>
        <div className='customize_padding'>
          <div>
            Detectable amount
          </div>
          <div>
            <Input style={{ width: '200px' }} placeholder="Detectable amount" onChange={handleChangeDetectableAmount} value={detectableAmount}  />
          </div>
        </div>
        <div className='customize_padding'>
          <div>
            Policy number
          </div>
          <div>
            <Input style={{ width: '200px' }} placeholder="start typing...." onChange={handleChangePolicyNumber} value={policyNumber}   />
          </div>
        </div>
      </div>
      <div className='customize_style'>
        <div className='customize_padding'>
          <div>
            Date of issue
          </div>
          <div>
          <DatePicker renderExtraFooter={() => 'extra footer'} onChange={handleChangeIssueDate} />
          </div>
        </div>
        <div className='customize_padding'>
          <div>
            Expiration date
          </div>
          <div>
          <DatePicker renderExtraFooter={() => 'extra footer'} onChange={handleChangeExpirationDate} />
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

    </>

  )
}

export default VehicleProtection;