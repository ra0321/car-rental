import React, { useState, useEffect } from "react";
import { Table, Modal, Form, Input, Select } from "antd";
import fetch from 'auth/FetchInterceptor';
import {
  EditOutlined,
  DeleteOutlined
} from '@ant-design/icons';



export default function Expand(props) {
  const columns = [
    {
      title: "Name",
      dataIndex: "name",
      key: "name",
    },
    {
      title: "Discription",
      dataIndex: "description",
      key: "discription"
    },
    {
      title: "Level",
      dataIndex: "level",
      key: "level"
    },
    {
      title: "Action",
      key: "action",
      render: (rowData) => (
        <>
          <div style={{ display: "flex" }}>
            <div style={{ padding: "10px" }}><EditOutlined onClick={handleEdit(rowData.key, rowData.name, rowData.description, rowData.level)} /></div>
            {/* <div style={{ padding: "10px" }}><DeleteOutlined onClick={handleDelete(rowData.key)} /></div> */}
          </div>
        </>
      )
    }
  ];
  const [isModalVisible, setIsModalVisible] = useState(false);
  const [loading, setLoading] = useState(false);
  const [data, setData] = useState([]);
  const [id, setId] = useState();
  const [name, setName] = useState("");
  const [description, setDescription] = useState("");
  const [level, setLevel] = useState("");
  const [reloadState, setReloadState] = useState(true);
  const handleEdit = (id, name, description, level) => () => {
    setId(id);
    setName(name);
    setDescription(description);
    setLevel(level);
    setIsModalVisible(true)

  }
  const fetchProducts = () => {
    setLoading(true);
    fetch({
      url: '/getRoles',
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
          description: item.description,
          level: item.level,
        }
        data.push(new_data);
      })
      setData(data);
    })
  }
  console.log(data);

  useEffect(() => {
    fetchProducts();
  }, [props.reloadState, reloadState]);
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
      level: level,
    }
    // console.log(new_data);

    fetch({
      url: '/EditRole/' + id,
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

  return (
    <>
      <Table columns={columns} dataSource={data} loading={loading} />
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
            <Input value={name} onChange={handleNameChange} />
          </Form.Item>
          <Form.Item label="Description" >
            <Input value={description} onChange={handleDescriptionChange} />
          </Form.Item>
          <Form.Item label="Select Level">
      
              <Select value={level} onChange={handleSelectLevel} >
                <Select.Option value="1" >1</Select.Option>
                <Select.Option value="2" >2</Select.Option>
                <Select.Option value="3" >3</Select.Option>
                <Select.Option value="4" >4</Select.Option>
                <Select.Option value="5" >5</Select.Option>
                <Select.Option value="6" >6</Select.Option>
                <Select.Option value="7" >7</Select.Option>
                <Select.Option value="8" >8</Select.Option>
                <Select.Option value="9" >9</Select.Option>
              </Select>

          </Form.Item>
        </Form>

      </Modal>
    </>
  )

}


