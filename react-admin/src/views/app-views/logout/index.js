import React, { useEffect } from 'react'
import { useDispatch } from 'react-redux';
import {  
	signOut
} from 'redux/actions/Auth';

const Logout = () => {
	const dispatch = useDispatch();
    useEffect(() => {
        dispatch(signOut());
    }, [dispatch]);
    return (
        <></>
    )
}

export default Logout
