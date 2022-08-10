import { all } from 'redux-saga/effects';
import Auth from './Auth';

export default function* rootSaga(getState) {
  yield all([
    Auth(),
  ]);
}
