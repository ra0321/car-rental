import React, {useEffect, useState}from 'react';
import { Button, Modal, Form, Select, Input } from "antd";
import { DownloadOutlined } from '@ant-design/icons';
import fetch from 'auth/FetchInterceptor';

import Table from './components/table';
import '../custom.css';

const Admin = () => {
	const [isModalVisible, setIsModalVisible] = useState(false);
	const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("")
    const [selectRole, setSelectRole] = useState("")
	const [roles , setRoles ] = useState([])
    const [reloadState, setReloadState] = useState(true);
	const handleAddAdmin = () => {
        setName("");
        setEmail("");
        setPassword("");
        setSelectRole("");
		setIsModalVisible(true);
		// console.log("name========>", name);
	}

    function success() {
        Modal.success({
          content: 'addmin add is sucessful.',
        });
      }

	const handleOk = () => {
        let params = {
            email: email,
            name: name,
            password: password,
            role: selectRole
        };
        fetch({
            url: '/admin_user',
            method: 'post',
            headers: {
                'public-request': 'true'
            },
            params,
        }).then((resp) => {
			setIsModalVisible(false);
            setReloadState(s => !s);
            success();
		})
        
    };

    const handleCancel = () => {
        setIsModalVisible(false);
    };
	const handleNameChange = (e) => {
        setName(e.target.value);
    }
    const handleEmailChange = (e) => {
        setEmail( e.target.value);
    }
    const handlePasswordChange = (e) => {
        setPassword(e.target.value);
    }
    const handleSelectChange = (e) => {
        // console.log("ssss", e);
        setSelectRole(e);
    }
	const getRole = () => {
		fetch({
            url: '/getRoles',
            method: 'get',
            headers: {
                'public-request': 'true'
            },
        }).then((resp) => {
			console.log(resp.data);
			setRoles(resp.data);
		})
	}
	useEffect(() => {
		getRole();
	},[]);
	return (
		<React.Fragment>
			
			<div className='RoleBtn'>
				<h1>ADMINISTRATORS</h1>
				<Button type="primary" onClick={handleAddAdmin}>ADD ADMIN</Button>
			</div>
			<div>
				<Table  reloadState={reloadState} roles={roles}/>
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
                    <Form.Item label="Email" rules={[{required: true, }, ]} >
                        <Input  onChange={handleEmailChange} value={email} />
                    </Form.Item>
                    <Form.Item label="Password" rules={[{required: true, }, ]} >
                        <Input type="password" onChange={handlePasswordChange} value={password}/>
                    </Form.Item>
                    <Form.Item label="Select Role" rules={[{required: true, }, ]}>
                        <Select value={selectRole} onChange={handleSelectChange} >
							 {roles.map((item, key) => {
								 return <Select.Option   value={item.name.toString()} key={key}>{item.name.toString()}</Select.Option>
							 })} 
                            
                        </Select>
                    </Form.Item>
                </Form>

            </Modal>
		</React.Fragment>
	)
}

export default Admin
