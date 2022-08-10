import React from 'react';
import { Select, Input, Upload, Modal } from 'antd';
import { PlusOutlined } from '@ant-design/icons';

function getBase64(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = error => reject(error);
  });
}

function Photos() {
  const { Option } = Select;
  const [previewVisible, setPreviewVisible] = React.useState(false);
  const [previewImage, setPreviewImage] = React.useState('');
  const [fileList, setFileList] = React.useState([]);

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
    console.log(fileList);
    setFileList([ ...fileList ]);
  }

  return (
    <>
      <h1>Car photos</h1>
      <div className='customize_style'>
        <div className='customize_padding'>
          <div>
           That's everything we needed! You're now redy to list car on ESAR. Remember, you can edit your listing and availablity anytime useing you car <br/>
           settings.
          </div>      
        </div>   
      </div>

    </>

  )
}

export default Photos;