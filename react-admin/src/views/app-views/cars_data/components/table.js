import React, { useState, useEffect, useRef } from "react";
import { Button, Table, Modal, Input, Form, Select, } from "antd";
import {
    EditOutlined,
    DeleteOutlined
} from '@ant-design/icons'

import fetch from 'auth/FetchInterceptor'

export default function Basic(props) {
    const { confirm } = Modal;
    const [loading, setLoading] = useState(false);
    const [pagination, setPagination] = useState({});
    const pageRef = useRef(pagination);
    const [data, setData] = useState();
    const [year, setYear] = useState("");
    const [make, setMake] = useState("");
    const [model, setModel] = useState("");
    const [transmission, setTransmission] = useState("");
    const [trim, setTrim] = useState("");
    const [style, setStyle] = useState("");
    const [id, setId] = useState("");
    const [isModalVisible, setIsModalVisible] = useState(false);
    const [reloadState, setReloadState] = useState(true);
    const columns = [
        {
            title: "Year",
            dataIndex: "year",
            key: "year",
        },
        {
            title: "Make",
            dataIndex: "make",
            key: "make"
        },
        {
            title: "Model",
            dataIndex: "model",
            key: "model"
        },
        {
            title: "Transmission",
            dataIndex: "transmission",
            key: "transmission"
        },
        {
            title: "Trim",
            dataIndex: "trim",
            key: "trim"
        },
        {
            title: "Style",
            dataIndex: "style",
            key: "style"
        },
        {
            title: "Action",
            key: "action",
            render: (rowData) => (
                <>
                    <div style={{ display: "flex" }}>
                        <div style={{ padding: "10px" }}><EditOutlined onClick={handleEdit(rowData)} /></div>
                        <div style={{ padding: "10px" }}><DeleteOutlined onClick={handleDelete(rowData)} /></div>
                    </div>
                </>
            )
        }

    ];
    const handleEdit = (rowData) => () => {
        console.log(rowData)
        setYear(rowData.year)
        setMake(rowData.make)
        setModel(rowData.model)
        setTrim(rowData.trim)
        setStyle(rowData.style)
        setTransmission(rowData.transmission);
        setId(rowData.id);
        setIsModalVisible(true)

    }
    const handleDelete = (rowData) => () => {
        confirm({
            title: "Do you want to delete these items?",
            content:
              "When clicked the OK button, this dialog will be closed after 1 second",
            onOk() {
                fetch({
                    url: '/car_data_delete/' + rowData.id,
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
    }
    const fetchProducts = (params) => {
        setLoading(true);
        fetch({
            url: '/car_data',
            method: 'get',
            headers: {
                'public-request': 'true'
            },
            params
        }).then((resp) => {
            var data = [];
            var new_data = {};
            setLoading(false);
            console.log(pagination, "++++");
            let newP = {...pageRef.current, total: resp.total};
            pageRef.current = newP;
            setPagination(newP);
            resp.data.map((item) => {
                new_data = {
                    key: item.id,
                    id: item.id,
                    year: item.model_year,
                    make: item.model_make_id,
                    model: item.model_name,
                    transmission: item.model_transmission_type,
                    trim: item.model_trim,
                    style: item.model_body
                }
                data.push(new_data);
            })
            setData(data);
        })
    }
    useEffect(() => {
        fetchProducts({ page: pageRef.current.current });
    }, [props.reloadState, reloadState]);
    const handleTableChange = (pager, filters, sorter) => {
        console.log(pager);
        pageRef.current = pager;
        setPagination({ ...pageRef.current, current: pager.current, pageSize: pager.pageSize });
        fetchProducts({
            page: pager.current,
            results: pager.pageSize,
            //   dates: props.startDate + "," + props.endDate,
            //   search: props.searchText
        });
    };
    const handleOk = () => {
        let params = {
            year: year,
            make: make,
            model: model,
            transmission: transmission,
            trim: trim,
            style: style,
            id: id,
        };
        console.log(params);
        fetch({
            url: '/car_data_update',
            method: 'post',
            headers: {
                'public-request': 'true'
            },
            params,
        }).then((resp) => {
            setIsModalVisible(false);
            setReloadState(s => !s);
        })
    };

    const handleCancel = () => {
        setIsModalVisible(false);
    };
    const handleYearChange = (e) => {
        setYear(e.target.value);
    }
    const handleMakeChange = (e) => {
        setMake(e.target.value);
    }
    const handleModelChange = (e) => {
        setModel(e.target.value);
    }
    const handleSelectTransmission = (e) => {
        setTransmission(e);
    }
    const handleTrimChange = (e) => {
        setTrim(e.target.value);
    }
    const handleStyleChange = (e) => {
        setStyle(e.target.value);
    }
    return (
        <>
            <Table columns={columns} dataSource={data} loading={loading} pagination={pagination} onChange={handleTableChange} />
            <Modal title="Add Car" visible={isModalVisible} onOk={handleOk} onCancel={handleCancel}>
                <Form
                    labelCol={{
                        span: 6,
                    }}
                    wrapperCol={{
                        span: 15,
                    }}
                    layout="horizontal"
                >
                    <Form.Item label="Year" rules={[{ required: true, },]}>
                        <Input onChange={handleYearChange} value={year} />
                    </Form.Item>
                    <Form.Item label="Make" rules={[{ required: true, },]} >
                        <Input onChange={handleMakeChange} value={make} />
                    </Form.Item>
                    <Form.Item label="Model" rules={[{ required: true, },]} >
                        <Input onChange={handleModelChange} value={model} />
                    </Form.Item>
                    <Form.Item label="Transmission" rules={[{ required: true, },]}>
                        <Select value={transmission} onChange={handleSelectTransmission} >
                            <Select.Option value="manual" >manual</Select.Option>
                            <Select.Option value="automatic" >automatic</Select.Option>
                        </Select>
                    </Form.Item>
                    <Form.Item label="Trim" rules={[{ required: true, },]} >
                        <Input onChange={handleTrimChange} value={trim} />
                    </Form.Item>
                    <Form.Item label="Style" rules={[{ required: true, },]} >
                        <Input onChange={handleStyleChange} value={style} />
                    </Form.Item>
                </Form>

            </Modal>
        </>
    );
}