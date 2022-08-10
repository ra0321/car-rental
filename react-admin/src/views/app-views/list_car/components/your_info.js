import React, {useEffect, useState} from 'react';
import { Select } from 'antd';

function YourInfo(props) {
    const { Option } = Select;
    const [ advance_notice, setAdvanceNotice] = useState("");
    const [ short_possible_trip, setShortPossibleTrip] = useState("");
    const [ long_possible_trip, setLongPossibleTrip] = useState("");
    function handleAdvanceNotice(value) {
        setAdvanceNotice(value);
       
    }
    function handleShortestPossibleTrip(value) {
        setShortPossibleTrip(value);      
    }
    function handleLongestPossibleTrip(value) {
        setLongPossibleTrip(value);
    }

    useEffect(() => {
        if (advance_notice !== '' && short_possible_trip !== '' && long_possible_trip !== '') {
            let data = {
                advance_notice: advance_notice,
                short_possible_trip: short_possible_trip,
                long_possible_trip: long_possible_trip
            }
            props.onSelectedValue(data);
        }
    }, [advance_notice, short_possible_trip, long_possible_trip])
  
    

    return (
        <>
            <h1>Car availability</h1>
            <div >
                <h4>How nuch advance do you need to confirom a trip?</h4>
                <div className='advance_notice'>
                    <div>Advance notice</div>
                    <Select defaultValue="" style={{ width: 120 }} onChange={handleAdvanceNotice}>
                        <Option value="1 hour">1 hour</Option>
                        <Option value="2 hours">2 hours</Option>
                        <Option value="3 hours">3 hours</Option>
                        <Option value="6 hours">6 hours</Option>
                        <Option value="12 hours">12 hours</Option>
                        <Option value="1 day">1 days</Option>
                        <Option value="2 days">2 days</Option>
                        <Option value="3 days">3 days</Option>
                        <Option value="1 week">1 weeks</Option>
                    </Select>
                </div>
                <div className='advance_notice'>Block tripts that don't give you enough notice</div>
            </div>
            <div>
                <h4>How long would you like trips to last?</h4>
                <div className='advance_notice'>
                    <div>Shortest possible trip</div>
                    <Select defaultValue="" style={{ width: 120 }} onChange={handleShortestPossibleTrip}>
                        <Option value="Any">Any</Option>
                        <Option value="1 day">1 day</Option>
                        <Option value="2 days">2 days</Option>
                        <Option value="3 days">3 days</Option>
                        <Option value="5 days">5 days</Option>
                        <Option value="1 week">1 week</Option>
                        <Option value="2 weeks">2 weeks</Option>
                        <Option value="1 month">1 month</Option>
                    </Select>
                </div>
                <div className='advance_notice'>
                    <div>Longest possible trip</div>
                    <Select defaultValue="" style={{ width: 120 }} onChange={handleLongestPossibleTrip}>
                        <Option value="Any">Any</Option>
                        <Option value="3 days">3 days</Option>
                        <Option value="5 days">5 days</Option>
                        <Option value="1 week">1 week</Option>
                        <Option value="2 weeks">2 weeks</Option>
                        <Option value="1 month">1 month</Option>
                        <Option value="3 months">3 months</Option>
                    </Select>
                </div>
            </div>
        </>

    )
}

export default YourInfo;