import React, { useState, useEffect } from "react";
import { Table, Modal, Button, Image } from 'antd';
import fetch from 'auth/FetchInterceptor'
import '../../custom.css';
import { 
  CheckCircleOutlined,
  CloseCircleOutlined,
  DownOutlined,
  UpOutlined,
  CheckOutlined,
  DeleteOutlined   
} from '@ant-design/icons';
import { APP_IMAGE_URL } from '../../../../configs/AppConfig';
import { AUTH_TOKEN } from '../../../../redux/constants/Auth';
const auth_token = localStorage.getItem(AUTH_TOKEN);

function getBase64(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = error => reject(error);
  });
}

export default function Expand(props) {

  const { confirm } = Modal;
  const [data, setData] = useState([]);
  const [images, setImages] = useState({});
  const [selCar, setSelCar] = useState(-1);
  const[ selCarInsurance ,setSelCarInsurance] = useState(-1);
  const[ selCarRegistraion ,setSelCarRegistraion] = useState(-1);
  const[ selOwner ,setSelOwner] = useState(-1);
  const [photo_show, setPhotoShow] = useState(false);
  const [car_insurance_show, setCarInsuranceShow] = useState(false);
  const [car_registration_show, setCarRegistrationShow] = useState(false);
  const [owner_show, setOwnerShow] = useState(false);
  const [pagination, setPagination] = useState({});
  const [loading, setLoading] = useState(false);
  const [changeButton, setChangeButton] = useState(true);
  const [carInsuranceData, setCarInsuranceData] = useState({});
  const [carVerifyButton, setCarVerifyButton] = useState(true);
  const [carRegiVerifyButton, setCarRegiVerifyButton] = useState(true);
  const [carRegistraionData, setCarRegistrationData] = useState({});
  
  const showConfirmDelete = (id) => () => {
    confirm({
      title: "Do you want to delete these items?",
      content:
        "When clicked the OK button, this dialog will be closed after 1 second",
      onOk() {
        fetch({
          url: '/cars/restore/' + id,
          method: 'post',
          headers: {
            'public-request': 'true'
          },
        }).then((resp) => {
          if(changeButton == true) {
            setChangeButton(false);
          } else {
            setChangeButton(true);
          }
        })
      },
      onCancel() { }
    });
  }
  const showConfirmRestore = (id) => () => {
    confirm({
      title: "Do you want to restore these items?",
      content:
        "When clicked the OK button, this dialog will be closed after 1 second",
      onOk() {
        fetch({
          url: '/cars/delete/' + id,
          method: 'post',
          headers: {
            'public-request': 'true'
          },
        }).then((resp) => {
          if(changeButton == true) {
            setChangeButton(false);
          } else {
            setChangeButton(true);
          }
        })
      },
      onCancel() { }
    });
  }
  const showConfirmDeny = (id) => () => {
    confirm({
      title: "Do you want to change these items?",
      content:
      "Are you sure you want to change insurance verification status of car",
      onOk() {
        fetch({
          url: '/car/insurance/deny/' + id,
          method: 'post',
          headers: {
            'public-request': 'true'
          },
        }).then((resp) => {
          if(carVerifyButton == true) {
            setCarVerifyButton(false);
          } else {
            setCarVerifyButton(true);
          }
        })
      },
      onCancel() { }
    });
  }
  const showConfirmVerify = (id) => () => {
    confirm({
      title: "Do you want to change these items?",
      content:
        "Are you sure you want to change insurance verification status of car",
      onOk() {
        fetch({
          url: '/car/insurance/approve/' + id,
          method: 'post',
          headers: {
            'public-request': 'true'
          },
        }).then((resp) => {
          if(carVerifyButton == true) {
            setCarVerifyButton(false);
          } else {
            setCarVerifyButton(true);
          }
        })
      },
      onCancel() { }
    });
  }
  const showRegistrationDeny = (id) => () => {
    confirm({
      title: "Do you want to change these items?",
      content:
        "Are you sure you want to change insurance verification status of car",
      onOk() {
        fetch({
          url: '/car/registration/deny/' + id,
          method: 'post',
          headers: {
            'public-request': 'true'
          },
        }).then((resp) => {
          if(carRegiVerifyButton == true) {
            setCarRegiVerifyButton(false);
          } else {
            setCarRegiVerifyButton(true);
          }
        })
      },
      onCancel() { }
    });
  }
  const showRegistrationVerify = (id) => () => {
    confirm({
      title: "Do you want to change these items?",
      content:
        "Are you sure you want to change insurance verification status of car",
      onOk() {
        fetch({
          url: '/car/registration/approve/' + id,
          method: 'post',
          headers: {
            'public-request': 'true'
          },
        }).then((resp) => {
          if(carRegiVerifyButton == true) {
            setCarRegiVerifyButton(false);
          } else {
            setCarRegiVerifyButton(true);
          }
        })
      },
      onCancel() { }
    });
  }
  const columns = [
    { title: 'CARD ID', dataIndex: 'id', key: 'card_id' },
    { title: 'Manufactuer', dataIndex: 'car_manufacturer', key: 'manufacuer' },
    { title: 'Model', dataIndex: 'car_model', key: 'model' },
    { title: 'Year', dataIndex: 'production_year', key: 'year' },
    { title: 'City', dataIndex: 'car_city', key: 'city' },
    { title: 'Active', dataIndex: 'active', key: 'active' },
    { title: 'OwnerId', dataIndex: 'owner_id', key: 'owner_id' },
    { title: 'OwnerName', dataIndex: 'owner_name', key: 'owner_name' },
    { title: 'CreatedOn', dataIndex: 'updated_at', key: 'create_on' },
    {
      title: 'Delete/Restore',
      render: (rowData) => {
        if (rowData.active == "NO") {
          const button = (
            <CheckOutlined
              onClick={showConfirmDelete(rowData.id)}
            >
            </CheckOutlined>
          );
          return button;
        } else {
          const button = (
            <DeleteOutlined
              onClick={showConfirmRestore(rowData.id)}
            >
            </DeleteOutlined >
          );
          return button;
        }

      }
    },
    {
      title: 'Verefied',
      render: (rowData) => {
        if (rowData.verified_insurance == 0) {

          return <div> <CloseCircleOutlined /> </div>

        } else {
          return <div> <CheckCircleOutlined /> </div>
        }
      },
    },
  ];
 
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
    fetchProducts();
  }, [changeButton, props.reloadState, carVerifyButton, carRegiVerifyButton]);
  const fetchProducts = (params) => {
    setLoading(true);
    fetch({
      url: '/cars',
      method: 'get',
      headers: {
        'Authorization': 'bearer ' +  auth_token,
        'public-request': 'true',
        "Access-Control-Allow-Headers": "'Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token'",
      },
      params
    }).then((resp) => {
      var data = [];
      var new_data = {};
      setPagination({ ...pagination, total: resp.meta.total });
      setLoading(false);
      resp.data.cars.map((item) => {
        item.active = item.active == 1 ? "Yes" : "NO";
        new_data = {
          key: item.id,
          id: item.id,
          car_manufacturer: item.car_manufacturer,
          car_model: item.car_model,
          production_year: item.production_year,
          car_city: item.car_city,
          active: item.active,
          owner_id: item.owner.id,
          owner_name: item.owner.first_name + item.owner.last_name,
          first_name: item.owner.first_name,
          last_name: item.owner.last_name,
          email: item.owner.email,
          phone_number: item.owner.phone_number,
          owner_created_at : item.owner.created_at,
          owner_updated_at: item.owner.updated_at,
          work_from_time: item.owner.work_from_time,
          work_until_time: item.owner.work_until_time,
          country_code: item.owner.country_code,
          account_number: item.owner.account_number,
          hold_name: item.owner.holder_name,
          iban: item.owner.iban,
          trips: item.owner.trips,
          listed: item.owner.listed,
          user_active_status: item.owner.user_active_status,
          approved_to_drive: item.owner.approved_to_drive,
          email_verified: item.owner.email_verified,
          id_verified: item.owner.id_verified,
          phone_verified: item.owner.phone_verified,
          reviewed: item.owner.reviewed,
          sms_notifications: item.owner.sms_notifications,
          car_trips: item.owner.car_trips,
          count_stars: item.owner.count_stars,
          user_stars: item.owner.user_stars,
          count_penalty_owner: item.owner.count_penalty_owner,
          count_penalty_renter: item.owner.count_penalty_renter,
          penalty_amount: item.owner.penalty_amount,
          penalty_period: item.owner.penalty_period,
          updated_at: item.created_at,
          style: item.style,
          type: item.type,
          car_odometer: item.car_odometer,
          created_at: item.created_at,
          deposit: item.deposit,
          value: item.value,
          stars: item.stars,
          shortest_trip: item.shortest_trip,
          lolongest_trip: item.longest_trip,
          notice: item.notice,
          guest_location_notice: item.guest_location_notice,
          car_location_notice: item.car_location_notice,
          airport_notice: item.airport_notice,
          key_handoff: item.key_handoff,
          parking_details: item.parking_details,
          verified_insurance: item.verified_insurance,
          verified_registration: item.verified_registration,
          weekend_trip: item.weekend_trip,
          long_term_trip: item.long_term_trip,
          paid_advertising: item.paid_advertising,
          reviews: item.reviews
          // description: 'My name is Joe Black, I am 32 years old, living in Sidney No. 1 Lake Park.',
        }
        data.push(new_data);
      })
      setData(data);
      props.getTableData(data)
      
    })
  }
  const expandPhotoDiv = (key) => () => {
    console.log("phto div button click event");
    if (selCar !== key) {
      setSelCar(key);

      fetch({
        url: '/car/' + key,
        method: 'get',
        headers: {
          'public-request': 'true'
        },
      }).then((resp) => {
        console.log(resp);
        setImages({ ...images, [key]: resp.images });
        setPhotoShow(true);
      })
    } else
      setPhotoShow(s => !s);
  }
  const expandCarInsuranceDiv = (key) => () =>{
    if (selCarInsurance !== key) {
      setSelCarInsurance(key);
      fetch({
        url: '/car/insurance/' + key,
        method: 'get',
        headers: {
          'public-request': 'true'
        },
      }).then((resp) => { 
        setCarInsuranceData(resp);  
        setCarInsuranceShow(true);
      })
    } else
      setCarInsuranceShow(s => !s);
  }
  const expandCarRegistrationDiv = (key)=>() => {
    if (selCarRegistraion !== key) {
      setSelCarRegistraion(key);
      fetch({
        url: '/car/registration/' + key,
        method: 'get',
        headers: {
          'public-request': 'true'
        },
      }).then((resp) => { 
        setCarRegistrationShow(true);
        setCarRegistrationData(resp); 
      })
      } else
      setCarRegistrationShow(s => !s);
  }
  const expendOwnerDiv = (key) =>() => {
    if (selOwner !== key) {
      setSelOwner(key);
      setOwnerShow(true);
      } else
       setOwnerShow(s => !s);
  }

  const handleTableChange = (pager, filters, sorter) => {
    setPagination({ ...pagination, current: pager.current });
    fetchProducts({
      page: pager.current,
      results: pager.pageSize,
      dates: props.startDate + "," + props.endDate,
      search: props.searchText
    });
  };

  const renderImages = (key) => {
    return images[key] && images[key].map((item, index) => {
      return (
        <Image
          key={index}
          width={200}
          src={APP_IMAGE_URL + item.small_image_path}
        />
      );
    });
  };

  return (
    <Table
      columns={columns}
      expandable={{
        expandedRowRender: record =>
          <div style={{ margin: 0 }}>
            <div>
              <div className="car_info_tab">
                <div className="car_info">
                  <div className="car_item">
                    <div className="car_info_detail">Car style</div>
                    <div className="car_item_detail">{record.style}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Car type</div>
                    <div className="car_item_detail">{record.type} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Odometer</div>
                    <div className="car_item_detail">{record.car_odometer} </div>
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
                    <div className="car_info_detail">Deposit</div>
                    <div className="car_item_detail">{record.deposit} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Value</div>
                    <div className="car_item_detail">{record.value} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Star</div>
                    <div className="car_item_detail">{record.stars} </div>
                  </div>
                </div>
                <div className="car_info">
                  <div className="car_item">
                    <div className="car_info_detail">Shortest trip</div>
                    <div className="car_item_detail">{record.shortest_trip} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Longest trip</div>
                    <div className="car_item_detail">{record.lolongest_trip} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Car notice</div>
                    <div className="car_item_detail">{record.notice} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Guest location notice</div>
                    <div className="car_item_detail">{record.guest_location_notice} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Car location notice</div>
                    <div className="car_item_detail">{record.car_location_notice} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Airport notice</div>
                    <div className="car_item_detail">{record.airport_notice} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Key handoff</div>
                    <div className="car_item_detail">{record.key_handoff} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Parking details</div>
                    <div className="car_item_detail">{record.parking_details} </div>
                  </div>
                </div>
                <div className="car_info">
                  <div className="car_item">
                    <div className="car_info_detail1">Car active</div>
                    <div className="car_info_icon">
                      {record.active == "Yes" ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                    </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail1">Verified insurance</div>
                    <div className="car_info_icon">
                      {record.verified_insurance == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                    </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail1">Verified registration</div>
                    <div className="car_info_icon">
                      {record.verified_registration == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                    </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail1">Weekend trip</div>
                    <div className="car_info_icon">
                      {record.weekend_trip == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                    </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail1">Long term trip</div>
                    <div className="car_info_icon">
                      {record.long_term_trip == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                    </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail1">Paid advertaising</div>
                    <div className="car_info_icon">
                      {record.paid_advertising == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                    </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail1">Reviews</div>
                    <div className="car_info_icon">
                      {record.review}
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div>
              <div className="photo_info"><h3>Photos:{record.key in images ? images[record.key].length : 0}</h3>
                <button onClick={expandPhotoDiv(record.key)}>{photo_show && selCar === record.key ? <UpOutlined /> : <DownOutlined />}</button>
              </div>
              {photo_show && selCar === record.key && (
                <div className="car_image">
                  <Image.PreviewGroup>
                    {renderImages(record.key)}
                  </Image.PreviewGroup>
                </div>
              )}
              <div className="photo_info"><h3>Car insurance</h3>
                <button onClick={expandCarInsuranceDiv(record.key)}>{car_insurance_show && selCarInsurance=== record.key ?  <UpOutlined /> : <DownOutlined />}</button>
              </div>
              {car_insurance_show && selCarInsurance=== record.key &&
                  <div>
                    <div className="car_insurance_body">
                      <div className="car_item">
                        <div className="car_insurance_detail">Car ID</div>
                        <div className="car_insurance_detail">{carInsuranceData.car_id}</div>
                      </div>
                      <div className="car_item">
                        <div className="car_insurance_detail">Created at</div>
                        <div className="car_insurance_detail">{carInsuranceData.created_at}</div>
                      </div>
                      <div className="car_item">
                        <div className="car_insurance_detail">Date of issue</div>
                        <div className="car_insurance_detail">{carInsuranceData.date_of_issue}</div>
                      </div>
                      <div className="car_item">
                        <div className="car_insurance_detail">Detectable amount</div>
                        <div className="car_insurance_detail">{carInsuranceData.detectable_amount}</div>
                      </div>
                      <div className="car_item">
                        <div className="car_insurance_detail">Expiration date</div>
                        <div className="car_insurance_detail">{carInsuranceData.expiration_date}</div>
                      </div>
                      <div className="car_item">
                        <div className="car_insurance_detail">ID</div>
                        <div className="car_insurance_detail">{carInsuranceData.id}</div>
                      </div>
                      <div className="car_item">
                        <div className="car_insurance_detail">Policy number</div>
                        <div className="car_insurance_detail">{carInsuranceData.policy_number}</div>
                      </div>
                      <div className="car_item">
                        <div className="car_insurance_detail">Updated at</div>
                        <div className="car_insurance_detail">{carInsuranceData.updated_at}</div>
                      </div>
                    </div>
                    <div className="car_insurance_footer">
                      {record.verified_insurance == 1 ? <Button type="primary" danger className="verify_button"  onClick={showConfirmDeny(record.key)}
                      >DENY</Button> :<Button type="primary" className="verify_button" onClick={showConfirmVerify(record.key)}>VERIFY</Button>}       
                    </div>
                  </div>}
              <div className="photo_info"><h3>Car registration</h3>
                <button onClick={expandCarRegistrationDiv(record.key)}>{car_registration_show && selCarRegistraion=== record.key? <UpOutlined /> : <DownOutlined />}</button>
                {/* <button onClick={expandCarRegistrationDiv}>{car_registration_show ? '+' : '-'}</button> */}
              </div>
              {car_registration_show && selCarRegistraion=== record.key&& 
                <div>
                  <div className="car_registraion_body">
                    <div className="car_registraion_body_left">
                    {carRegistraionData.small_car_registration_image == null ?  <Image
                      width={340}
                      height={390}
                      src={"https://as1.ftcdn.net/v2/jpg/04/34/72/82/1000_F_434728286_OWQQvAFoXZLdGHlObozsolNeuSxhpr84.jpg"}
                    /> :<Image
                    width={340}
                    height={390}
                    src={APP_IMAGE_URL + carRegistraionData.small_car_registration_image}
                    />}
                    {/* <img src={"https://s3.ap-south-1.amazonaws.com/esarcar/" + carRegistraionData.small_car_registration_image} width="340" height="390" /> */}
                    </div>
                    <div className="car_registraion_body_right">
                      <div className="car_item">
                        <div className="car_insurance_detail">Car ID</div>
                        <div className="car_insurance_detail">{carRegistraionData.car_id}</div>
                      </div>
                      <div className="car_item">
                        <div className="car_insurance_detail">City</div>
                        <div className="car_insurance_detail">{carRegistraionData.city}</div>
                      </div>
                      <div className="car_item">
                        <div className="car_insurance_detail">State</div>
                        <div className="car_insurance_detail">{carRegistraionData.state}</div>
                      </div>
                      <div className="car_item">
                        <div className="car_insurance_detail">Country</div>
                        <div className="car_insurance_detail">{carRegistraionData.country}</div>
                      </div>
                      <div className="car_item">
                        <div className="car_insurance_detail">Created at</div>
                        <div className="car_insurance_detail">{carRegistraionData.created_at}</div>
                      </div>
                      <div className="car_item">
                        <div className="car_insurance_detail">Date of issue</div>
                        <div className="car_insurance_detail">{carRegistraionData.date_of_issue}</div>
                      </div>
                      <div className="car_item">
                        <div className="car_insurance_detail">Expiration date</div>
                        <div className="car_insurance_detail">{carRegistraionData.expiration_date}</div>
                      </div>
                      <div className="car_item">
                        <div className="car_insurance_detail"> ID</div>
                        <div className="car_insurance_detail">{carRegistraionData.id}</div>
                      </div>
                      <div className="car_item">
                        <div className="car_insurance_detail">Licence plate</div>
                        <div className="car_insurance_detail">{carRegistraionData.licence_plate}</div>
                      </div>
                      <div className="car_item">
                        <div className="car_insurance_detail">Updated at</div>
                        <div className="car_insurance_detail">{carRegistraionData.updated_at}</div>
                      </div>
                    </div>
                  </div>
                  <div className="car_registrion_footer">
                      {record.verified_registration == 1 ? <Button type="primary" danger className="verify_button"  onClick={showRegistrationDeny(record.key)}
                      >DENY</Button> :<Button type="primary" className="verify_button" onClick={showRegistrationVerify(record.key)}>VERIFY</Button>}       
                  </div>
                </div>}
            </div>
            <div className="photo_info"><h3>Owner</h3>
              <button onClick={expendOwnerDiv(record.key)}>{owner_show && selOwner=== record.key ? <UpOutlined /> : <DownOutlined />}</button>
              {/* <button onClick={expendOwnerDiv}>{owner_show ? '+' : '-'}</button> */}
            </div>
            {owner_show && selOwner=== record.key &&
              <div className="total_owner">
                <div className="owner">
                  <div className="car_item">
                    <div className="car_insurance_detail">First name</div>
                    <div className="car_insurance_detail">{record.first_name}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">Last name</div>
                    <div className="car_insurance_detail">{record.last_name}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">ID</div>
                    <div className="car_insurance_detail">{record.owner_id}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail"> E-mail</div>
                    <div className="car_insurance_detail">{record.email}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">Phone number</div>
                    <div className="car_insurance_detail">{record.phone_number}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">Created at</div>
                    <div className="car_insurance_detail">{record.owner_created_at}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">Updated at</div>
                    <div className="car_insurance_detail">{record.owner_updated_at}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">Work from time</div>
                    <div className="car_insurance_detail">{record.work_from_time}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">Work until time</div>
                    <div className="car_insurance_detail">{record.work_until_time}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">Country code</div>
                    <div className="car_insurance_detail">{record.country_code}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">Account number</div>
                    <div className="car_insurance_detail">{record.account_number}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">Holder name</div>
                    <div className="car_insurance_detail">{record.hold_name}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">IBAN</div>
                    <div className="car_insurance_detail">{record.iban}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">Trips</div>
                    <div className="car_insurance_detail">{record.trips}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">Listed</div>
                    <div className="car_insurance_detail">{record.listed}</div>
                  </div>
                </div>
                <div className="owner">
                  <div className="car_item">
                      <div className="car_insurance_detail">User active</div>
                      <div className="car_insurance_detail">{record.user_active_status ==1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}</div>
                    </div>
                    <div className="car_item">
                      <div className="car_insurance_detail">Approved to drive</div>
                      <div className="car_insurance_detail">{record.approved_to_drive ==1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}</div>
                    </div>
                    <div className="car_item">
                      <div className="car_insurance_detail">E-mail verified</div>
                      <div className="car_insurance_detail">{record.email_verified ==1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}</div>
                    </div>
                    <div className="car_item">
                      <div className="car_insurance_detail">ID verified</div>
                      <div className="car_insurance_detail">{record.id_verified == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}</div>
                    </div>
                    <div className="car_item">
                      <div className="car_insurance_detail">Phone verified</div>
                      <div className="car_insurance_detail">{record.phone_verified == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}</div>
                    </div>
                    <div className="car_item">
                      <div className="car_insurance_detail">Reviewed</div>
                      <div className="car_insurance_detail">{record.reviewed == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}</div>
                    </div>
                    <div className="car_item">
                      <div className="car_insurance_detail">SMS notifications</div>
                      <div className="car_insurance_detail">{record.sms_notifications == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}</div>
                    </div>
                    <div className="car_item">
                      <div className="car_insurance_detail">Car trips</div>
                      <div className="car_insurance_detail">{record.car_trips}</div>
                    </div>
                    <div className="car_item">
                      <div className="car_insurance_detail">Count stars</div>
                      <div className="car_insurance_detail">{record.count_stars}</div>
                    </div>
                    <div className="car_item">
                      <div className="car_insurance_detail">User stars</div>
                      <div className="car_insurance_detail">{record.user_stars}</div>
                    </div>
                    <div className="car_item">
                      <div className="car_insurance_detail">Penalties as owner</div>
                      <div className="car_insurance_detail">{record.count_penalty_owner}</div>
                    </div>
                    <div className="car_item">
                      <div className="car_insurance_detail">Penalties as renter</div>
                      <div className="car_insurance_detail">{record.count_penalty_renter}</div>
                    </div>
                    <div className="car_item">
                      <div className="car_insurance_detail">Penalty amount</div>
                      <div className="car_insurance_detail">{record.penalty_amount}</div>
                    </div>
                    <div className="car_item">
                      <div className="car_insurance_detail">Penalty period</div>
                      <div className="car_insurance_detail">{record.penalty_period}</div>
                    </div>
                </div>
              </div>
              }
          </div>,
      }}
      dataSource={data}
      pagination={pagination}
      onChange={handleTableChange}
      loading={loading}
    />
  );
}
