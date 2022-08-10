import React, { useState } from "react";
import { Button, Modal, Input, Form, Select, } from "antd";
import Table from './components/table';
import '../custom.css';
import fetch from 'auth/FetchInterceptor'

const CarsData = () => {
    const [isModalVisible, setIsModalVisible] = useState(false);
    const [year, setYear] = useState("");
    const [make, setMake] = useState("");
    const [model, setModel] = useState("");
    const [transmission, setTransmission] = useState("");
    const [trim, setTrim] = useState("");
    const [style, setStyle] = useState("");
    const [reloadState, setReloadState] = useState(true);
    const handleAddCar = () => {
        setYear("")
        setMake("")
        setModel("")
        setTrim("")
        setStyle("")
        setIsModalVisible(true);
    }
    const handleOk = () => {
        let params = {
            year: year,
            make: make,
            model: model,
            transmission: transmission,
            trim: trim,
            style: style,
        };
        console.log(params);
        fetch({
            url: '/car_data',
            method: 'post',
            headers: {
                'public-request': 'true'
            },
            params,
        }).then((resp) => {
            // setIsModalVisible(false);
            setYear("")
            setMake("")
            setModel("")
            setTrim("")
            setStyle("")
            setReloadState(s => !s);
            setTransmission("")
            // // success();
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
        <React.Fragment>

            <div className='RoleBtn'>
                <h1>Cars Database</h1>
                <Button type="primary" onClick={handleAddCar}>ADD CAR</Button>
            </div>
            <div>
                <Table reloadState={reloadState} />
            </div>
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

        </React.Fragment>
    )
}

export default CarsData