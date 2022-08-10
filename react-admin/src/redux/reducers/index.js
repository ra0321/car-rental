import { combineReducers } from 'redux';
import Auth from './Auth';
import Theme from './Theme';

const reducers = combineReducers({
    theme: Theme,
    auth: Auth
});

export default reducers;