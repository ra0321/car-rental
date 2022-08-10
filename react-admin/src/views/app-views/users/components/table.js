import React, { useState, useEffect } from "react";
import { Table, Modal, Button, Image  } from 'antd';
import fetch from 'auth/FetchInterceptor';
import '../../custom.css';
import { 
  CheckCircleOutlined,
  CloseCircleOutlined,
  DownOutlined,
  UpOutlined,
  CheckOutlined,
  DeleteOutlined   
} from '@ant-design/icons';

export default function Expand(props) {
    const { confirm } = Modal;
    const [loading, setLoading] = useState(false);
    const [data, setData] = useState([]);
    const [pagination, setPagination] = useState({});
    const [changeButton, setChangeButton] = useState(true);
    const [photo_show, setPhotoShow] = useState(false);
    const [profile_detail_show, setProfileDetailShow] = useState(false);
    const [car_show, setCarShow] = useState(false);
    const [selPhoto, setSelPhoto] = useState();
    const [selProfile, setSelProfile] = useState();
    const [selCar, setSelCar] = useState();
    const [idPhoto, setIdPhoto] = useState();
    const [driverPhoto, setDriverPhoto] = useState();
    const [profilePhoto, setProfilePhoto] = useState();
    const [changeIdVerify, setChangeIdVerify] = useState(false);
    const [changeDriverVerify, setChangeDriverVerify] = useState(false);
    const [profileData, setProfileData] = useState({});
    const [carData, setCarsData] = useState({});
    const columns = [
        { title: 'USER ID', dataIndex: 'id', key: 'id', fixed: "left"},
        { title: 'First name', dataIndex: 'first_name', key: 'first_name', fixed: "left" },
        { title: 'Last name', dataIndex: 'last_name', key: 'last_name' },
        { title: 'Email', dataIndex: 'email', key: 'email' },
        { title: 'Listed Cars', dataIndex: 'listed_cars', key: 'listed_cars' },
        { title: 'Joined', dataIndex: 'joined', key: 'joined' },
        { title: 'Phone number', dataIndex: 'phone_number', key: 'phone_number' },
        { title: 'Car trips', dataIndex: 'car_trips', key: 'car_trips' },
        { title: 'Active', dataIndex: 'active', key: 'active' },
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
        { title: 'Verified',
          render: (rowData) => {
            if (rowData.id_verified == 1) {
              const button = (
               <CheckCircleOutlined/>
              );
              return button;
            } else {
              const button = (
               <CloseCircleOutlined/>
              );
              return button;
            }
    
          } 
        },
        { title: 'Not Status', 
        render: (rowData) => {
          console.log(rowData.note_staus);
          if (rowData.not_status == null) {
            const button = (
             <CheckCircleOutlined/>
            );
            return button;
          } else {
            const button = (
             <CloseCircleOutlined/>
            );
            return button;
          }
  
        } 
        
        },
        {
          title: 'Note'
          , fixed: "right",
          render: (rowData) => {
            // if (rowData.active == "NO") {
            //   const button = (
            //     <CheckOutlined
            //       onClick={showConfirmDelete(rowData.id)}
            //     >
            //     </CheckOutlined>
            //   );
            //   return button;
            // } else {
            //   const button = (
            //     <DeleteOutlined
            //       onClick={showConfirmRestore(rowData.id)}
            //     >
            //     </DeleteOutlined >
            //   );
            //   return button;
            // }
    
          }
        },
      ];
      
    const fetchProducts = (params) => {
      setLoading(true);
        fetch({
          url: '/users',
          method: 'get',
          headers: {
            'public-request': 'true'
          },
          params
        }).then((resp) => {
          setLoading(false);
          var data = [];
          var new_data = {};
          setPagination({ ...pagination, total: resp.meta.total });
          resp.data.users.map((item) => {
              // console.log(item);
              item.active = item.active == 1 ? "Yes" : "NO";
              new_data = {
                key: item.id,
                id: item.id,
                first_name: item.first_name,
                last_name: item.last_name,
                email: item.email,
                listed_car: item.listed_cars,
                joined: item.joined,
                phone_number: item.phone_number,
                car_trips: item.car_trips,
                active: item.active,
                id_verified: item.id_verified,
                accepted_trips_in_row: item.accepted_trips_in_row,
                number_of_penalties: item.number_of_penalties,
                // shortest_trip: item.cars[0].shortest_trip,
                penalty_amount: item.penalty_amount,
                stars: item.stars,
                trips_taken: item.trips_taken,
                approved_to_drive: item.approved_to_drive,
                email_verified: item.email_verified,
                id_verified: item.id_verified,
                phone_verified: item.phone_verified,
                reviewed: item.reviewed,
                bank_name: item.bank_name,
                account_number: item.account_number,
                iban: item.iban,
                holder_name: item.holder_name,
                note_staus: item.note
                // driver_licence_image_path_small: item.profile.driver_licence_image_path_small,
                // id_image_path_small: item.profile.id_image_path_small,


                // description: 'My name is Joe Black, I am 32 years old, living in Sidney No. 1 Lake Park.',
              }
              data.push(new_data);
              // console.log(data);
            })
            setData(data);   
            props.getTableData(data)
        })
      }
      // console.log(data);
    const handleTableChange = (pager, filters, sorter) => {

        setPagination({ ...pagination, current: pager.current });
        fetchProducts({
          page: pager.current,
          results: pager.pageSize,
          dates: props.startDate + "," + props.endDate,
          search: props.searchText,
          active: props.selectActive
        });
      };

    useEffect(() => {
        if (props.startDate === undefined)
          fetchProducts({ page: 1 });
        else
          fetchProducts({ page: 1, dates: props.startDate + "," + props.endDate, search: props.searchText, active: props.selectActive});
      }, [props.reloadState, props.startDate, props.endDate, props.searchText, props.selectActive, changeButton, changeIdVerify,changeDriverVerify]);
    const showConfirmDelete = (id) => () => {
      confirm({
        title: "Do you want to delete these items?",
        content:
          "When clicked the OK button, this dialog will be closed after 1 second",
        onOk() {
          fetch({
            url: '/users/restore/' + id,
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
            url: '/users/delete/' + id,
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
    const expandPhotoDiv = (key) => () =>{
      if (selPhoto !== key) {
          fetch({
            url: '/user/' + key,
            method: 'get',
            headers: {
              'public-request': 'true'
            },
          }).then((resp) => {
            console.log(resp);
            // setImages({ ...images, [key]: resp.images });
            setIdPhoto(resp.profile.id_image_path_small);
            setDriverPhoto(resp.profile.driver_licence_image_path_small);
            setProfilePhoto(resp.profile.profile_photo);
            setPhotoShow(true);
          })
        setSelPhoto(key);
      } else
        setPhotoShow(s => !s);
    }
    const expandProfileDetail = (key) => () =>{
      if (selProfile !== key) {
        fetch({
          url: '/user/' + key,
          method: 'get',
          headers: {
            'public-request': 'true'
          },
        }).then((resp) => {
          console.log(resp);
          setProfileData(resp.profile);
          setProfileDetailShow(true);
        })
      setSelProfile(key);
    } else
    setProfileDetailShow(s => !s);
    }
    const expandCarsDiv = (key) => () =>{
      if (selCar !== key) {
        fetch({
          url: '/user/' + key,
          method: 'get',
          headers: {
            'public-request': 'true'
          },
        }).then((resp) => {
          console.log(resp.cars[0]);
          if (resp.cars[0] == undefined) {
            resp.cars[0] = {};
          }
          setCarsData(resp.cars[0]);
          setCarShow(true);
        })
      setSelCar(key);
    } else
    setCarShow(s => !s);
    }
    const viewPhoto = (url) => () => {
      if (url === null) {
        console.log("this page is null")
      }
      window.location = 'https://s3.ap-south-1.amazonaws.com/esarcar/'+ url;
    }
    
    const changeApproveIdVerfiy = (key) => () => {
      if(changeIdVerify == true) {
        setChangeIdVerify(false)
      }
      fetch({
        url: '/users/approve/id/' + key,
        method: 'post',
        headers: {
          'public-request': 'true'
        },
      }).then((resp) => {
        setChangeIdVerify(true);
      })
    }
    const changeIdDenyVerfiy = (key) => () => {
      if(changeIdVerify == true) {
        setChangeIdVerify(false)
      }
      fetch({
        url: '/users/deny/id/' + key,
        method: 'post',
        headers: {
          'public-request': 'true'
        },
      }).then((resp) => {
        setChangeIdVerify(true);
      })
    }
    const changeApproveDriverVerfiy = (key) => () => {
      if(changeDriverVerify == true) {
        setChangeDriverVerify(false)
      }
      fetch({
        url: '/users/approve/licence/' + key,
        method: 'post',
        headers: {
          'public-request': 'true'
        },
      }).then((resp) => {
        setChangeDriverVerify(true);
      })
    }
    const changeDriverDenyVerfiy = (key) => () => {
      if(changeDriverVerify == true) {
        setChangeDriverVerify(false)
      }
      fetch({
        url: '/users/deny/licence/' + key,
        method: 'post',
        headers: {
          'public-request': 'true'
        },
      }).then((resp) => {
        setChangeDriverVerify(true);
      })
    }
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
                    <div className="car_info_detail">Accepted trips in row</div>
                    <div className="car_item_detail">{record.accepted_trips_in_row}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Joined</div>
                    <div className="car_item_detail">{record.joined} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Listed cars</div>
                    <div className="car_item_detail">{record.listed_car} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Number of penalties</div>
                    <div className="car_item_detail">{record.number_of_penalties} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Shortest trip</div>
                    <div className="car_item_detail">{record.shortest_trip} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Penalty amount</div>
                    <div className="car_item_detail">{record.penalty_amount} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Stars</div>
                    <div className="car_item_detail">{record.stars} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Stars as owner</div>
                    {/* <div className="car_item_detail">{record.stars} </div> */}
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Stars as renter</div>
                    {/* <div className="car_item_detail">{record.stars} </div> */}
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Trips taken</div>
                    <div className="car_item_detail">{record.trips_taken} </div>
                  </div>
                </div>
                <div className="car_info">
                  <div className="car_item">
                    <div className="car_info_detail">Active</div>
                    <div className="uers_detail_change_icon">
                      {record.active == "Yes" ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                    </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Approved to drive</div>
                    <div className="uers_detail_change_icon">
                      {record.approved_to_drive  == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                    </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">email verified</div>
                    <div className="uers_detail_change_icon">
                      {record.email_verified == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                    </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">id verified</div>
                    <div className="uers_detail_change_icon">
                      {record.id_verified == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                    </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Phone verified</div>
                    <div className="uers_detail_change_icon">
                      {record.phone_verified == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                    </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">reviewed</div>
                    <div className="uers_detail_change_icon">
                      {record.reviewed == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />}
                    </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Bank name</div>
                    {/* <div className="car_item_detail">{record.key_handoff} </div> */}
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Account number</div>
                    {/* <div className="car_item_detail">{record.parking_details} </div> */}
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">IBAN</div>
                    {/* <div className="car_item_detail">{record.parking_details} </div> */}
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Holder name</div>
                    {/* <div className="car_item_detail">{record.parking_details} </div> */}
                  </div>
                </div>
              </div>
              <div className="photo_info"><h3>Photos</h3>
                <button onClick={expandPhotoDiv(record.key)}>{photo_show && selPhoto=== record.key ?  <UpOutlined /> : <DownOutlined />}</button>
               
              </div>
                {photo_show &&  selPhoto=== record.key && 
                <div>
                  <div className="car_info_tab">
                  <div className="car_info">
                    {profilePhoto == null ? <Image
                      width={310}
                      height={250}
                      src={"https://as1.ftcdn.net/v2/jpg/04/34/72/82/1000_F_434728286_OWQQvAFoXZLdGHlObozsolNeuSxhpr84.jpg"}
                    /> : <Image
                      width={310}
                      src={"https://s3.ap-south-1.amazonaws.com/esarcar/" + profilePhoto}
                    />}
                    <div>Profile Photo</div>
                    <div className="profileBtn">
                      <Button type="primary" className="verify_button" onClick={viewPhoto(profilePhoto)} >VIEW</Button>    
                        
                    </div>
                  </div>
                  <div className="car_info">
                    {idPhoto == null ? <Image
                      width={310}
                      height={250}
                      src={"https://as1.ftcdn.net/v2/jpg/04/34/72/82/1000_F_434728286_OWQQvAFoXZLdGHlObozsolNeuSxhpr84.jpg"}
                    /> : <Image
                    width={310}
                    height={250}
                    src={"https://s3.ap-south-1.amazonaws.com/esarcar/" + idPhoto}
                    />}
                    <div>Id Photo</div>
                    <div className="verifyBtn">
                     
                      {record.id_verified == 1 ?  <Button type="primary" danger  className="verify_button" onClick={changeIdDenyVerfiy(record.key)}>DENY</Button>  :  <Button type="primary"   className="verify_button" onClick={changeApproveIdVerfiy(record.key)}>APPROVE</Button> }
                      <Button type="primary" className="verify_button" onClick={viewPhoto(idPhoto)} >VIEW</Button>    
                        
                    </div>
                  </div>
                  <div className="car_info">
                    {driverPhoto == null ?  <Image
                      width={310}
                      height={250}
                      src={"https://as1.ftcdn.net/v2/jpg/04/34/72/82/1000_F_434728286_OWQQvAFoXZLdGHlObozsolNeuSxhpr84.jpg"}
                    /> :<Image
                    width={310}
                    height={250}
                    src={"https://s3.ap-south-1.amazonaws.com/esarcar/" + driverPhoto}
                    />}
                    <div>Driver licence photo</div>
                    <div className="verifyBtn">
                      {record.approved_to_drive == 1 ?  <Button type="primary" danger  className="verify_button" onClick={changeDriverDenyVerfiy(record.key)}>DENY</Button>  :  <Button type="primary"   className="verify_button" onClick={changeApproveDriverVerfiy(record.key)}>APPROVE</Button> }
                      <Button type="primary" className="verify_button"  onClick={viewPhoto(driverPhoto)}>VIEW</Button>    
                        
                    </div>
                  </div>
                </div>
                </div>} 
              <div className="photo_info"><h3>Profile details</h3>
                <button onClick={expandProfileDetail(record.key)}>{profile_detail_show && selProfile=== record.key ?  <UpOutlined /> : <DownOutlined />}</button>
              </div>
              {profile_detail_show &&  selProfile=== record.key &&
               <div>
                <div className="car_insurance_body">
                  <div className="car_item">
                    <div className="car_insurance_detail">Address</div>
                    <div className="car_insurance_detail">{profileData.address}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">Created at</div>
                    {/* <div className="car_insurance_detail">{profileData.created_at}</div> */}
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">Date of issue</div>
                    <div className="car_insurance_detail">{profileData.date_of_issue}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">Date of birth</div>
                    <div className="car_insurance_detail">{profileData.dob}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">Driver licence date of issue</div>
                    <div className="car_insurance_detail">{profileData.driver_licence_data_of_issue}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">Driver licence expiration date</div>
                    <div className="car_insurance_detail">{profileData.driver_licence_expiration_date}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">Driver licence number</div>
                    <div className="car_insurance_detail">{profileData.driver_licence_number}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail"> Expiration date</div>
                    <div className="car_insurance_detail">{profileData.expiration_date}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail">Expired driver licence</div>
                    <div className="car_insurance_detail">{profileData.expired}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail"> City id</div>
                    <div className="car_insurance_detail">{profileData.id_city}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail"> Country id</div>
                    <div className="car_insurance_detail">{profileData.id_country}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail"> Number ID</div>
                    <div className="car_insurance_detail">{profileData.id_number}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail"> State ID</div>
                    <div className="car_insurance_detail">{profileData.id_state}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail"> Issued by</div>
                    <div className="car_insurance_detail">{profileData.issued_by}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail"> Language</div>
                    <div className="car_insurance_detail">{profileData.language}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail"> First name</div>
                    <div className="car_insurance_detail">{profileData.first_name}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail"> Middle name</div>
                    <div className="car_insurance_detail">{profileData.middle_name}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail"> Last name</div>
                    <div className="car_insurance_detail">{profileData.last_name}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail"> School</div>
                    <div className="car_insurance_detail">{profileData.school}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail"> Updated at</div>
                    <div className="car_insurance_detail">{profileData.updated_at}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_insurance_detail"> Works</div>
                    <div className="car_insurance_detail">{profileData.works}</div>
                  </div>
                </div>
             </div>} 
              <div className="photo_info"><h3>Cars Info</h3>
                <button onClick={expandCarsDiv(record.key)}>{car_show && selCar=== record.key ?  <UpOutlined /> : <DownOutlined />}</button>
              </div>
              {car_show &&  selCar=== record.key &&
               <div className="car_info_tab">
                <div className="car_info">
                  <div className="car_item">
                    <div className="car_info_detail">Style</div>
                    <div className="car_item_detail">{carData.style}</div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Odometer</div>
                    <div className="car_item_detail">{carData.car_odometer} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Value</div>
                    <div className="car_item_detail">{carData.value} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Created at</div>
                    <div className="car_item_detail">{carData.created_at} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Updated at</div>
                    <div className="car_item_detail">{carData.updated_at} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Deposit</div>
                    <div className="car_item_detail">{carData.deposit} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Star</div>
                    <div className="car_item_detail">{carData.stars} </div>
                  </div>
                </div>
                <div className="car_info">
                  <div className="car_item">
                    <div className="car_info_detail">Shortest trip</div>
                    <div className="car_item_detail">{carData.shortest_trip} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Long trip</div>
                    <div className="car_item_detail">{carData.lolongest_trip} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Car notice</div>
                    <div className="car_item_detail">{carData.notice} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Guest location notice</div>
                    <div className="car_item_detail">{carData.guest_location_notice} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Car location notice</div>
                    <div className="car_item_detail">{carData.car_location_notice} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Airport notice</div>
                    <div className="car_item_detail">{carData.airport_notice} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Key handoff</div>
                    <div className="car_item_detail">{carData.key_handoff} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Parking dtails</div>
                    <div className="car_item_detail">{carData.parking_details} </div>
                  </div>
                </div>
                <div className="car_info">
                  <div className="car_item">
                    <div className="car_info_detail">ID</div>
                    <div className="car_item_detail">{carData.id} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Car  active</div>
                    {/* {record.reviewed == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />} */}
                    <div className="car_item_detail">{carData.active == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Verified insurance</div>
                    <div className="car_item_detail">{carData.verified_insurance ==1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Verified registration</div>
                    <div className="car_item_detail">{carData.verified_registration == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Weekend trip</div>
                    <div className="car_item_detail">{carData.weekend_trip == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />} </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Long term trip</div>
                    <div className="car_item_detail">{carData.long_term_trip == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined /> } </div>
                  </div>
                  <div className="car_item">
                    <div className="car_info_detail">Paid advertaising</div>
                    <div className="car_item_detail">{carData.paid_advertising == 1 ? <CheckCircleOutlined /> : <CloseCircleOutlined />} </div>
                  </div>
                </div>
             </div>} 
            </div>
          </div>,
        }}
        dataSource={data}
        pagination={pagination}
        loading={loading}
        scroll={{ x: 1300 }}
        onChange={handleTableChange}
      />
    );
  }



