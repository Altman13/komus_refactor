import { AppActions } from './../models/actions';
//import uuid from "uuid"
import { call } from "../models"
import {
    ADD_CALL,
    REMOVE_CALL,
    EDIT_CALL,
    SET_CALL,
} from "../models/actions"
import { Dispatch } from "redux"
export const addCall = (call: call): AppActions => ({
    type: ADD_CALL,
    call
})

export const removeCall = (id: string): AppActions => ({
    type: REMOVE_CALL,
    id
})

export const editCall = (call: call): AppActions => ({
    type: EDIT_CALL,
    call
})

export const setCall = (call: call[]): AppActions => ({
    type: SET_CALL,
    call
})

export const startRemoveCall = (id: string) => {
  return (dispatch: Dispatch<AppActions>, getState: () => AppState) => {
    dispatch(removeCall(id))
  }
}

export const startEditCall = (call: call) => {
  return (dispatch: Dispatch<AppActions>, getState: () => AppState) => {
    dispatch(editCall(call))
  }
}

export const startUpdateCall = (call: call[]) => {
  return (dispatch: Dispatch<AppActions>, getState: () => AppState) => {
    dispatch(editCall(call))
  }
}
