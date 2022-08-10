import React, { useState, useEffect } from "react";
import { Table, Modal, Button } from 'antd';
import fetch from 'auth/FetchInterceptor';
import '../../custom.css';
import {
    CheckCircleOutlined,
    CloseCircleOutlined,
    DownOutlined,
    UpOutlined,
    CheckOutlined,
    DeleteOutlined,
    SnippetsOutlined
} from '@ant-design/icons';
import { isEmpty } from "lodash";


export default function Expand(props) {
    const { confirm } = Modal;
    const [isModalVisible, setIsModalVisible] = useState(false);
    const [isChangeStatusModalVisible, setIsChangeStatusModalVisible] = useState(false);
    const [loading, setLoading] = useState(false);
    const [data, setData] = useState([]);
    const [pagination, setPagination] = useState({});
    const [selPhoto, setSelPhoto] = useState();
    const [photo_show, setPhotoShow] = useState(false);
    const [selCar, setSelCar] = useState();
    const [car_show, setCarShow] = useState(false);
    const [selTrip, setSelTrip] = useState();
    const [trip_show, setTripShow] = useState(false);
    const [selChart, setSelChart] = useState();
    const [chart_show, setChartShow] = useState(false);
    const [images, setImages] = useState([]);
    const [photo_data, setPhotoData] = useState({});
    const [chat, setChat] = useState({});
    const [status, setStatus] = useState(false);
    const [rowDataid, setRowDataId] = useState();
    const columns = [
        {
            title: "TRIPS ID",
            width: 100,
            dataIndex: "trips_id",
            key: "trips_id",
            fixed: "left"
        },
        {
            title: "Booking Date",
            width: 100,
            dataIndex: "booking_date",
            key: "booking_date",
            fixed: "left"
        },
        { title: "Start date", dataIndex: "start_date", key: "start_date" },
        { title: "End date", dataIndex: "end_date", key: "end_date" },
        { title: "Status", dataIndex: "status", key: "status" },
        { title: "Trip Days", dataIndex: "trip_day", key: "trip_day" },
        { title: "Price Per Day", dataIndex: "price_per_day", key: "price_per_day" },
        { title: "Promo Discount", dataIndex: "promo_discount", key: "promo_discount" },
        { title: "Discount", dataIndex: "discount", key: "discount" },
        { title: "Total Trip Price", dataIndex: "total_trip_price", key: "total_trip_price" },
        { title: "Trans Ref", dataIndex: "trans_ref", key: "trans_ref" },
        { title: "Esar Commision", dataIndex: "esar_commision", key: "esar_commision" },
        { title: "Pickup location ", dataIndex: "pickup_location", key: "pickup_location" },
        { title: "Notice time", dataIndex: "notice_time", key: "notice_time" },
        { title: "Renter ID", dataIndex: "renter_id", key: "renter_id" },
        { title: "Renter full name", dataIndex: "renter_full_name", key: "renter_full_name" },
        { title: "Renter Phone", dataIndex: "renter_phone", key: "renter_phone" },
        { title: "Owner ID", dataIndex: "owner_id", key: "owner_id" },
        { title: "Owner full name", dataIndex: "owner_fullname", key: "owner_fullname" },
        { title: "Owner Phone", dataIndex: "owner_phone", key: "owner_phone" },
        { title: "Owner Earning", dataIndex: "owner_earning", key: "owner_earning" },
        { title: "Car ID", dataIndex: "car_id", key: "car_id" },
        { title: "Manufacturer", dataIndex: "manufacturer", key: "manufacturer" },
        { title: "Model", dataIndex: "model", key: "model" },
        { title: "Year", dataIndex: "year", key: "year" },
        {
            title: "Note",
            fixed: "right",
            width: "150px",
            render: (rowData) => {
                const button = (
                    <>
                        <Button icon={<SnippetsOutlined />} onClick={showModal(rowData.trips_id)} >Note</Button>
                        <Modal title="Testing Modal" visible={isModalVisible} onOk={handleOk} onCancel={handleCancel}>
                            <p>Some contents...</p>
                            <p>Some contents...</p>
                            <p>Some contents...</p>
                        </Modal>
                    </>
                );
                return button;
            }
        },
        {
            title: "Action",
            fixed: "right",
            width: 100,
            render: (rowData) => {
                const button = (
                    <>
                        <Button icon={<SnippetsOutlined />} onClick={showChangeStatus(rowData.trips_id)}>STOP/FINISH</Button>
                    </>
                );
                return button;
            }
        }
    ];

    const showModal = (id) => () => {
        setIsModalVisible(true);
        console.log(id);
        // confirm({
        //   title: "Do you want to change these items?",
        //   content:
        //     "Are you sure you want to change insurance verification status of car",
        //   onOk() {
        //     fetch({
        //       url: '/car/insurance/approve/' + id,
        //       method: 'post',
        //       headers: {
        //         'public-request': 'true'
        //       },
        //     }).then((resp) => {
        //       if(carVerifyButton == true) {
        //         setCarVerifyButton(false);
        //       } else {
        //         setCarVerifyButton(true);
        //       }
        //     })
        //   },
        //   onCancel() { }
        // });
    }

    const showChangeStatus = (id) => () => {
        setRowDataId(id);
        console.log(id);
        if (status == true) {
            setStatus(false);
        }
        setIsChangeStatusModalVisible(true);
    }

    const handleOk = () => {
        setIsModalVisible(false);
    };

    const handleCancel = () => {
        setIsModalVisible(false);
    };

    const handleFinished = (id) => () => {
        fetch({
            url: '/trips/stop/' + id,
            method: 'post',
            headers: {
                'public-request': 'true'
            },
        }).then((resp) => {
            setIsChangeStatusModalVisible(false);
            setStatus(true);
        })

    };

    const handleWaiting = (id) => () => {
        fetch({
            url: '/trips/waiting/' + id,
            method: 'post',
            headers: {
                'public-request': 'true'
            },
        }).then((resp) => {
            setIsChangeStatusModalVisible(false);
            setStatus(true);
        })
    };
    const handleStarted = (id) => () => {
        fetch({
            url: '/trips/start/' + id,
            method: 'post',
            headers: {
                'public-request': 'true'
            },
        }).then((resp) => {
            setIsChangeStatusModalVisible(false);
            setStatus(true);
        })
    };
    const handleCanceled = (id) => () => {
        fetch({
            url: '/trips/cancel/' + id,
            method: 'post',
            headers: {
                'public-request': 'true'
            },
        }).then((resp) => {
            setIsChangeStatusModalVisible(false);
            setStatus(true);
        })
    };

    const fetchProducts = (params) => {
        setLoading(true);
        fetch({
            url: '/trips',
            method: 'get',
            headers: {
                'public-request': 'true'
            },
            params
        }).then((resp) => {
            console.log(resp.data.trips);
            setLoading(false);
            var data = [];
            var new_data = {}
            setPagination({ ...pagination, total: resp.meta.total });
            resp.data.trips.map((item, key) => {
                console.log(item, key);
                new_data = {
                    key: key,
                    trips_id: item.id,
                    booking_date: item.created_at,
                    start_date: item.start_date,
                    created_at: item.created_at,
                    updated_at: item.updated_at,
                    end_date: item.end_date,
                    status: item.status,
                    trip_day: item.trip_bill.trip_days,
                    price_per_day: item.trip_bill.price_per_day,
                    promo_discount: item.trip_bill.promo_discount,
                    discount: item.trip_bill.discount_amount,
                    total_trip_price: item.trip_bill.trip_price,
                    trans_ref: item.trip_bill.tran_ref,
                    esar_commision: item.trip_bill.esar_earning,
                    pickup_location: item.pickup_location,
                    notice_time: item.notice_time,
                    renter_id: item.renter.id,
                    renter_full_name: item.renter.first_name + item.renter.last_name,
                    renter_phone: item.renter.phone_number,
                    owner_id: item.owner_id,
                    owner_fullname: item.owner.first_name + item.owner.last_name,
                    owner_phone: item.owner.phone_number,
                    owner_earning: item.trip_bill.owner_earning,
                    car_id: item.car.id,
                    manufacturer: item.car.car_manufacturer,
                    model: item.car.car_model,
                    year: item.car.production_year,
                    owner_email: item.owner.email,
                    owner_country_code: item.owner.country_code,
                    owner_start_date: item.owner.start_date,
                    owner_end_date: item.owner.end_date,
                    owner_created_at: item.owner.created_at,
                    owner_updated_at: item.owner.updated_at,
                    renter_email: item.renter.email,
                    renter_country_code: item.renter.country_code,
                    renter_confirm_trip: item.renter_confirm_trip,
                    owner_confirm_trip: item.owner_confirm_trip,
                    renter_confirm_update: item.renter_confirm_trip_update,
                    owner_confirm_update: item.owner_confirm_trip_update,
                    booked_instantly: item.booked_instantly,
                    delivery_on_airport: item.delivery_on_airport,
                    delivery_on_car_location: item.delivery_on_car_location,
                    delivery_on_renter_location: item.delivery_on_renter_location,
                    trip_modified: item.trip_modified,
                    car_style: item.car.style,
                    car_odometer: item.car.car_odometer,
                    car_value: item.car.car_value,
                    car_created_at: item.car.created_at,
                    car_updated_at: item.car.updated_at,
                    car_deposit: item.car.deposit,
                    car_star: item.car.count_stars,
                    car_short_trip: item.car.short_trip,
                    car_long_trip: item.car.long_trip,
                    car_notice: item.car.notice,
                    car_guest_location_notice: item.car.guest_location_notice,
                    car_car_location_notice: item.car.car_location_notice,
                    car_airport_notice: item.car.airport_notice,
                    car_key_hand_off: item.car.key_hand_off,
                    car_parking_detail: item.car.parking_details,
                    car_active: item.car.car_is_active,
                    car_verify_insurance: item.car.is_insurance_verified,
                    car_verify_registrion: item.car.is_registration_car_verified,
                    car_weekend_trip: item.car.weekend_trip,
                    car_long_term_trip: item.car.long_term_trip,
                    car_paid_advertising: item.car.paid_advertising,
                    average_price: item.trip_bill.average_price,
                    delivery_fee: item.trip_bill.delivery_fee,
                    trip_doposit: item.trip_bill.deposit,
                    monthly_discount: item.trip_bill.discount_mont,
                    weekly_discount: item.trip_bill.discount_week,
                    discount_amount: item.trip_bill.discount_amount,
                    promo_code: item.trip_bill.promo_code,
                    promo_code_discount: item.trip_bill.promo_code_discount,
                    service_fee: item.trip_bill.service_fee,
                    trip_paid: item.trip_bill.trip_paid,
                    esar_earning: item.trip_bill.esar_earning,
                    owner_earning: item.trip_bill.owner_earning,
                    price_with_discount: item.trip_bill.price_with_discount,
                    price_with_promo_discount: item.trip_bill.promo_discount,
                    tran_ref: item.trip_bill.tran_ref,
                    trip_bill_status: item.trip_bill.trip_bill_status,
                    trip_days: item.trip_bill.trip_days,
                    trip_price: item.trip_bill.trip_price,
                    trip_total: item.trip_bill.trip_total,
                    trip_bill_start_date: item.trip_bill.trip_start_date,
                    trip_bill_end_date: item.trip_bill.trip_end_date,

                }
                data.push(new_data);
            })
            setData(data);
            props.getTableData(data)
        })
    }
    useEffect(() => {
        if (props.startDate === undefined || props.searchText === undefined)
            fetchProducts({ page: 1 });
        else
            fetchProducts({ page: 1, dates: props.startDate + "," + props.endDate, search: props.searchText });
    }, []);
    useEffect(() => {
        if (props.startDate === undefined)
            fetchProducts({ page: 1 });
        else
            fetchProducts({ page: 1, dates: props.startDate + "," + props.endDate, search: props.searchText });
    }, [props.startDate, props.endDate, props.searchText]);
    useEffect(() => {
        fetchProducts({ page: 1 });
    }, [status, props.reloadState]);

    const handleTableChange = (pager, filters, sorter) => {

        setPagination({ ...pagination, current: pager.current });
        fetchProducts({
            page: pager.current,
            results: pager.pageSize,
            dates: props.startDate + "," + props.endDate,
            search: props.searchText,
            // active: props.selectActive
        });
    };

    const expandPhotoDiv = (key) => () => {
        if (selPhoto !== key) {
            fetch({
                url: '/trip/' + key,
                method: 'get',
                headers: {
                    'public-request': 'true'
                },
            }).then((resp) => {
                console.log(resp.trip_images);
                setImages({ ...images, [key]: resp.trip_images });
                setPhotoData(resp.trip_images[0]);
                // setIdPhoto(resp.profile.id_image_path_small);
                // setDriverPhoto(resp.profile.driver_licence_image_path_small);
                // setProfilePhoto(resp.profile.profile_photo);
                setPhotoShow(true);
            })
            setSelPhoto(key);
        } else
            setPhotoShow(s => !s);
    }
    const expandCarsDiv = (key) => () => {
        if (selCar !== key) {
            setCarShow(true);
            setSelCar(key);
        } else
            setCarShow(s => !s);
    }
    const expandTripBillsDiv = (key) => () => {
        if (selTrip !== key) {
            setTripShow(true);
            setSelTrip(key);
        } else
            setTripShow(s => !s);
    }
    const expandChatDiv = (key) => () => {
        if (selChart !== key) {
            fetch({
                url: '/chat/trip/' + key,
                method: 'get',
                headers: {
                    'public-request': 'true'
                },
            }).then((resp) => {
                console.log(resp);
                setChat(resp);
                setChartShow(true);
            })
            setSelChart(key);
        } else
            setChartShow(s => !s);
    }
    return (
        <>
            <Table
                columns={columns}
                expandable={{
                    expandedRowRender: record =>
                        <div style={{ margin: 0 }}>
                            <div className="car_info_tab">
                                <div className="trip_info">
                                    <div className="car_item">
                                        <div className="car_info_detail">Owner Name</div>
                                        <div className="car_item_detail">{record.owner_fullname}</div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Owner Email</div>
                                        <div className="car_item_detail">{record.owner_email} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Owner Country Code</div>
                                        <div className="car_item_detail">{record.owner_country_code} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Owner Phone</div>
                                        <div className="car_item_detail">{record.owner_phone} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Start date</div>
                                        <div className="car_item_detail">{record.start_date} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">End date</div>
                                        <div className="car_item_detail">{record.end_date} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Created at</div>
                                        <div className="car_item_detail">{record.created_at} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Updated at</div>
                                        <div className="car_item_detail">{record.updated_at} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Notice time</div>
                                        <div className="car_item_detail">{record.notice_time} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Pickup location</div>
                                        <div className="car_item_detail">{record.pickup_location} </div>
                                    </div>
                                </div>
                                <div className="trip_info">
                                    <div className="car_item">
                                        <div className="car_info_detail">Renter Name</div>
                                        <div className="car_item_detail">{record.renter_full_name} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Renter Email</div>
                                        <div className="car_item_detail">{record.renter_email} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Renter Country Code</div>
                                        <div className="car_item_detail">{record.renter_country_code} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Renter Phone</div>
                                        <div className="car_item_detail">{record.renter_phone} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Renter confirm trip</div>
                                        <div className="car_item_detail">{record.renter_confirm_trip} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Owner confirm trip</div>
                                        <div className="car_item_detail">{record.owner_confirm_trip} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Renter confirm trip update</div>
                                        <div className="car_item_detail">{record.renter_confirm_update} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Owner confirm trip update</div>
                                        <div className="car_item_detail">{record.owner_confirm_update} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Booked instantly:</div>
                                        <div className="car_item_detail">{record.booked_instantly} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Delivery on airporte</div>
                                        <div className="car_item_detail">{record.delivery_on_airport} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Delivery on car location</div>
                                        <div className="car_item_detail">{record.delivery_on_car_location} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Delivery on renter location</div>
                                        <div className="car_item_detail">{record.delivery_on_renter_location} </div>
                                    </div>
                                    <div className="car_item">
                                        <div className="car_info_detail">Trip modified</div>
                                        <div className="car_item_detail">{record.trip_modified} </div>
                                    </div>
                                </div>
                            </div>
                            <div className="photo_info"><h3>Photos</h3>
                                <button onClick={expandPhotoDiv(record.trips_id)}>{photo_show && selPhoto === record.trips_id ? <UpOutlined /> : <DownOutlined />}</button>
                            </div>
                            {photo_show && selPhoto === record.trips_id && <div className="car_image">{
                                record.trips_id in images && images[record.trips_id].map((item, index) => {
                                    return <div key={index} className="trip_info">
                                        <img src={"https://s3.ap-south-1.amazonaws.com/esarcar/" + item.small_image_path} width="330" height="230" />
                                        <div className="car_item">
                                            <div className="car_info_detail">Created at</div>
                                            <div className="car_item_detail">{item.created_at}</div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Updated at</div>
                                            <div className="car_item_detail">{item.updated_at}</div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">before trip</div>
                                            <div className="car_item_detail">
                                                {item.before_trip == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                                            </div>
                                        </div>
                                    </div>

                                })
                            }</div>}
                            <div className="photo_info"><h3>Cars</h3>
                                <button onClick={expandCarsDiv(record.trips_id)}>{car_show && selCar === record.trips_id ? <UpOutlined /> : <DownOutlined />}</button>
                            </div>
                            {car_show && selCar === record.trips_id &&
                                <div className="car_info_tab">
                                    <div className="car_info">
                                        <div className="car_item">
                                            <div className="car_info_detail">Style</div>
                                            <div className="car_item_detail">{record.car_style}</div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Odometer</div>
                                            <div className="car_item_detail">{record.car_odometer} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Value</div>
                                            <div className="car_item_detail">{record.car_value} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Created at</div>
                                            <div className="car_item_detail">{record.car_created_at} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Updated at</div>
                                            <div className="car_item_detail">{record.car_updated_at} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Deposit</div>
                                            <div className="car_item_detail">{record.car_deposit} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Star</div>
                                            <div className="car_item_detail">{record.car_star} </div>
                                        </div>

                                    </div>
                                    <div className="car_info">
                                        <div className="car_item">
                                            <div className="car_info_detail">Short trip</div>
                                            <div className="car_item_detail">{record.car_short_trip} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Long trip</div>
                                            <div className="car_item_detail">{record.car_long_trip} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Car notice</div>
                                            <div className="car_item_detail">{record.car_notice} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Guest location notice</div>
                                            <div className="car_item_detail">{record.car_guest_location_notice} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Car location notice</div>
                                            <div className="car_item_detail">{record.car_car_location_notice} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Airport notice</div>
                                            <div className="car_item_detail">{record.car_airport_notice} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Key handoff</div>
                                            <div className="car_item_detail">{record.car_key_hand_off} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Paking detials</div>
                                            <div className="car_item_detail">{record.car_parking_detail} </div>
                                        </div>
                                    </div>
                                    <div className="car_info">
                                        <div className="car_item">
                                            <div className="car_info_detail">ID</div>
                                            <div className="car_item_detail">{record.car_id} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Car active</div>
                                            <div className="car_item_detail">
                                                {record.car_active == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                                            </div>
                                            {/* <div className="car_item_detail">{record.car_active} </div> */}
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Verified insurance</div>
                                            <div className="car_item_detail">
                                                {record.car_verify_insurance == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                                            </div>
                                            {/* <div className="car_item_detail">{record.car_verify_insurance} </div> */}
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Verified registraion</div>
                                            <div className="car_item_detail">
                                                {record.car_verify_registrion == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                                            </div>
                                            {/* <div className="car_item_detail">{record.car_verify_registrion} </div> */}
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Weekend trip</div>
                                            <div className="car_item_detail">
                                                {record.car_weekend_trip == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                                            </div>
                                            {/* <div className="car_item_detail">{record.car_weekend_trip} </div> */}
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Long term trip</div>
                                            <div className="car_item_detail">
                                                {record.car_long_term_trip == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                                            </div>
                                            {/* <div className="car_item_detail">{record.car_long_term_trip} </div> */}
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Paid advertaising</div>
                                            <div className="car_item_detail">
                                                {record.car_paid_advertising == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                                            </div>
                                            {/* <div className="car_item_detail">{record.car_paid_advertising} </div> */}
                                        </div>
                                    </div>
                                </div>}
                            <div className="photo_info"><h3>Trip bills</h3>
                                <button onClick={expandTripBillsDiv(record.key)}>{trip_show && selTrip === record.key ? <UpOutlined /> : <DownOutlined />}</button>
                            </div>
                            {trip_show && selTrip === record.key &&
                                <div className="car_info_tab">
                                    <div className="trip_info">
                                        <div className="car_item">
                                            <div className="car_info_detail">Average price</div>
                                            <div className="car_item_detail">{record.average_price}</div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Delivery fee</div>
                                            <div className="car_item_detail">{record.delivery_fee} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Deposit</div>
                                            <div className="car_item_detail">{record.trip_doposit} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Monthly discount</div>
                                            <div className="car_item_detail">{record.monthly_discount} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Weekly dicount</div>
                                            <div className="car_item_detail">{record.weekly_discount} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Discount amount</div>
                                            <div className="car_item_detail">{record.discount_amount} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Promo code</div>
                                            <div className="car_item_detail">{record.promo_code} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Promo code discount</div>
                                            <div className="car_item_detail">{record.promo_code_discount} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Promo discount</div>
                                            <div className="car_item_detail">{record.promo_discount} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Service fee</div>
                                            <div className="car_item_detail">{record.service_fee} </div>
                                        </div>

                                    </div>
                                    <div className="trip_info">
                                        <div className="car_item">
                                            <div className="car_info_detail">Trip paid</div>
                                            <div className="car_item_detail">{record.trip_paid} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">ESAR earining</div>
                                            <div className="car_item_detail">{record.esar_earning} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Qwner earining</div>
                                            <div className="car_item_detail">{record.owner_earning} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Price with discount</div>
                                            <div className="car_item_detail">{record.price_with_discount} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Price with promo discount</div>
                                            <div className="car_item_detail">{record.price_with_promo_discount} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Transation reference</div>
                                            <div className="car_item_detail">{record.tran_ref} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Trip bill status</div>
                                            <div className="car_item_detail">{record.trip_bill_status} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Trip days</div>
                                            <div className="car_item_detail">{record.trip_days} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Trip price</div>
                                            <div className="car_item_detail">{record.trip_price} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Trip total</div>
                                            <div className="car_item_detail">{record.trip_total} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Trip bill start date</div>
                                            <div className="car_item_detail">{record.trip_bill_start_date} </div>
                                        </div>
                                        <div className="car_item">
                                            <div className="car_info_detail">Trip bill end date</div>
                                            <div className="car_item_detail">{record.trip_bill_end_date} </div>
                                        </div>
                                    </div>

                                </div>}
                            <div className="photo_info"><h3>Chat</h3>
                                <button onClick={expandChatDiv(record.trips_id)}>{chart_show && selChart === record.trips_id ? <UpOutlined /> : <DownOutlined />}</button>
                            </div>
                            {chart_show && selChart === record.trips_id &&
                                <div >
                                    {chat && chat.messages && chat.messages.map((item) => {
                                        return <div className="chat_info">
                                            <div className="total_owner">
                                                <div className="bold">{chat.renter.first_name + chat.renter.last_name}</div>
                                                <div className="bold">{chat.renter.id}</div>
                                            </div>
                                            <div>{item.created_at}</div>
                                            <div>{item.message}</div>
                                        </div>
                                    })}
                                </div>}
                        </div>,
                }}
                dataSource={data}
                pagination={pagination}
                loading={loading}
                scroll={{ x: 2500 }}
                onChange={handleTableChange}
            />
            <Modal title="Do you want to change these items?" visible={isChangeStatusModalVisible}
                footer={[
                    <Button key="1" onClick={handleFinished(rowDataid)}>FINISHED</Button>,
                    <Button key="2" onClick={handleWaiting(rowDataid)}>WAITING</Button>,
                    <Button key="3" onClick={handleCanceled(rowDataid)}>CANCELED</Button>,
                    <Button key="4" onClick={handleStarted(rowDataid)}>STARTED</Button>,
                ]}
            >

                <p>Are you sure you want to change status of trip?</p>

            </Modal>

        </>
    );
}

