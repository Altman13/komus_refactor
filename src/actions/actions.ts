import { contact } from "./../models/call";
import { AppActions } from "./../models/actions";

//import uuid from "uuid"
// import { call } from "../models"
// import {
//     ADD_CALL,
//     REMOVE_CALL,
//     EDIT_CALL,
//     SET_CALLS,
// } from "../models/actions"
import { RECEIVE_CALL, MAKE_CALL } from "../models/actions";
//import { contact} from '../models';

import { Dispatch } from "redux";
import { AppState } from "../store";
export const makeCall = (contact: contact): AppActions => ({
  type: MAKE_CALL,
  contact
});
export const receiveCall = (contact: contact): AppActions => ({
  type: RECEIVE_CALL,
  contact
});
// export const addCall = (call: call): AppActions => ({
//     type: ADD_CALL,
//     call
// })

// export const removeCall = (id: string): AppActions => ({
//     type: REMOVE_CALL,
//     id
// })

// export const editCall = (call: call): AppActions => ({
//     type: EDIT_CALL,
//     call
// })

// export const setCall = (calls: call[]): AppActions => ({
//     type: SET_CALLS,
//     calls
// })

// export const startRemoveCall = (id: string) => {
//   return (dispatch: Dispatch<AppActions>, getState: () => AppState) => {
//     dispatch(removeCall(id))
//   }
// }

// export const startEditCall = (call: call) => {
//   return (dispatch: Dispatch<AppActions>, getState: () => AppState) => {
//     dispatch(editCall(call))
//   }
// }

// export const startUpdateCall = (calls: call[]) => {
//   return (dispatch: Dispatch<AppActions>, getState: () => AppState) => {
//     dispatch(setCall(calls))
//   }
//}
