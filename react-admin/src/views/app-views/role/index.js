import React, {useEffect, useState}from 'react';
import { Button, Modal, Input , Form, Select,} from "antd";
import { DownloadOutlined } from '@ant-design/icons';
import fetch from 'auth/FetchInterceptor';

import Table from './components/table';
import '../custom.css';

const Role = () => {
	const [isModalVisible, setIsModalVisible] = useState(false);
	const [name, setName] = useState("");
    const [description, setDescription] = useState("");
    const [level, setLevel] = useState("")
	const [reloadState, setReloadState] = useState(true);
	const handleAddRole = () => {
		setName("");
        setDescription("");
        setLevel("");
		setIsModalVisible(true);
	}
	const handleNameChange = (e) => {
        setName(e.target.value);
    }
	const handleDescriptionChange = (e) => {
        setDescription(e.target.value);
    }

	const handleSelectLevel = (e) => {
		setLevel(e);
	}
	const handleOk = () => { 
		let params = {
            name: name,
            description: description,
			level: level
        };
        fetch({
            url: '/role',
            method: 'post',
            headers: {
                'public-request': 'true'
            },
            params,
        }).then((resp) => {
			setIsModalVisible(false);
            setReloadState(s => !s);
            // success();
		}) 
    };

    const handleCancel = () => {
        setIsModalVisible(false);
    };
	
	return (
		<React.Fragment>
			
			<div className='RoleBtn'>
				<h1>ROLE MANAGEMENT</h1>
				<Button type="primary" onClick={handleAddRole}>ADD ROLE</Button>
			</div>
			<div>
				<Table reloadState={reloadState}/>
			</div>
			<Modal title="Add Admin" visible={isModalVisible} onOk={handleOk} onCancel={handleCancel}>
                <Form
                    labelCol={{
                        span: 4,
                    }}
                    wrapperCol={{
                        span: 14,
                    }}
                    layout="horizontal"
                >
                    <Form.Item label="Name" rules={[{required: true, }, ]}>
                        <Input onChange={handleNameChange} value={name} />
                    </Form.Item>
                    <Form.Item label="Description" rules={[{required: true, }, ]} >
                        <Input  onChange={handleDescriptionChange} value={description} />
                    </Form.Item>
                    <Form.Item label="Select Level" rules={[{required: true, }, ]}>
                        <Select value={level} onChange={handleSelectLevel} >
							<Select.Option   value="1" >1</Select.Option>
							<Select.Option   value="2" >2</Select.Option>
							<Select.Option   value="3" >3</Select.Option>
                            <Select.Option   value="4" >4</Select.Option>
							<Select.Option   value="5" >5</Select.Option>
							<Select.Option   value="6" >6</Select.Option>
							<Select.Option   value="7" >7</Select.Option>
							<Select.Option   value="8" >8</Select.Option>
							<Select.Option   value="9" >9</Select.Option>
                        </Select>
                    </Form.Item>
                </Form>

            </Modal>

		</React.Fragment>
	)
}

export default Role
