import React, { useEffect, useState } from "react";
import { Table, Modal, Form, Input, Select} from "antd";
import fetch from 'auth/FetchInterceptor';
import {
    EditOutlined,
    DeleteOutlined
} from '@ant-design/icons';



export default function Expand(props) {
    const { confirm } = Modal;
    const [data, setData] = useState([]);
    const [isModalVisible, setIsModalVisible] = useState(false);
    const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("")
    const [roles, setRoles] = useState("");
    const [id, setId] = useState();
    const [loading, setLoading] = useState(false);
    const [reloadState, setReloadState] = useState(true);
    const columns = [
        {
            title: "Name",
            dataIndex: "name",
            key: "name",
        },
        {
            title: "Email",
            dataIndex: "email",
            key: "email"
        },
        {
            title: "Roles",
            dataIndex: "roles",
            key: "roles"
        },
        {
            title: "Action",
            key: "action",
            render: (rowData) => (
                <>
                    <div style={{ display: "flex" }}>
                        <div style={{ padding: "10px" }}><EditOutlined onClick={handleEdit(rowData.key, rowData.name, rowData.email, rowData.roles)} /></div>
                        <div style={{ padding: "10px" }}><DeleteOutlined onClick={handleDelete(rowData.key)} /></div>
                    </div>
                </>
            )
        }
    ];
    const handleEdit = (id, name, email,roles ) => () => {
        setId(id);
        setName(name);
        setEmail(email);
        setPassword("password");
        setRoles(roles);
        setIsModalVisible(true)
        
    }
    const handleDelete = (id) => () => {
        confirm({
            title: "Do you want to delete these items?",
            content:
              "When clicked the OK button, this dialog will be closed after 1 second",
            onOk() {
                fetch({
                    url: '/deleteAdmin/' + id,
                    method: 'post',
                    headers: {
                        'public-request': 'true'
                    },
                }).then((resp) => {
                    setReloadState(s => !s);
                   
                })
            },
            onCancel() { }
          });
        
        // fetch({
        //     url: '/deleteAdmin/' + id,
        //     method: 'post',
        //     headers: {
        //         'public-request': 'true'
        //     },
        // }).then((resp) => {
        //     setReloadState(s => !s);
           
        // })
    }
    const handleOk = () => {
        let params = {
            name: name,
            email: email,
            password: password,
            role: roles
        }
        // console.log(new_data);

        fetch({
            url: '/editAdmin/' +id,
            method: 'post',
            headers: {
                'public-request': 'true'
            },
            params
            
        }).then((resp) => {
            setReloadState(s => !s);
        })
        setIsModalVisible(false);
    };

    const handleCancel = () => {
        setIsModalVisible(false);
    };
    const fetchProducts = () => {
        setLoading(true);
        fetch({
            url: '/getAdmin',
            method: 'get',
            headers: {
                'public-request': 'true'
            },
        }).then((resp) => {
            setLoading(false);
            let data = [];
            let new_data = {};
            resp.data.map(item => {
                new_data = {
                    key: item.id,
                    name: item.name,
                    email: item.email,
                    roles: item.role.role_name.name,
                }
                data.push(new_data);
            })
            setData(data);
        })
    }
    useEffect(() => {
        fetchProducts();
    }, [props.reloadState, reloadState]);

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
        setRoles(e);
    }
    return (
        <>
            <Table columns={columns} dataSource={data}  loading={loading} />
            <Modal title="Basic Modal" visible={isModalVisible} onOk={handleOk} onCancel={handleCancel}>
                <Form
                    labelCol={{
                        span: 4,
                    }}
                    wrapperCol={{
                        span: 14,
                    }}
                    layout="horizontal"
                >
                    <Form.Item label="Name">
                        <Input value={name} onChange={handleNameChange}/>
                    </Form.Item>
                    <Form.Item label="Email" >
                        <Input value={email} onChange={handleEmailChange}/>
                    </Form.Item>
                    <Form.Item label="Password" >
                        <Input type="password" value={password} onChange={handlePasswordChange} />
                    </Form.Item>
                    <Form.Item label="Select Role">
                        <Select value={roles} onChange={handleSelectChange}>
                            {props.roles.map((item, key) => {
								 return <Select.Option   value={item.name.toString()} key={key}>{item.name.toString()}</Select.Option>
							 })} 
                        </Select>
                    </Form.Item>
                </Form>

            </Modal>
        </>
    )
}


