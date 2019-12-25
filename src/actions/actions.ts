//import uuid from "uuid"
import { call } from "../models"
import {
    ADD_CALL,
    REMOVE_CALL,
    EDIT_CALL,
    SET_CALL,
} from "../models/actions"
import { Dispatch } from "redux"
export const addCall = (call: call): any => ({
    type: ADD_CALL,
    call
})

export const removeCall = (id: string): any => ({
    type: REMOVE_CALL,
    id
})

export const editCall = (call: call): any => ({
    type: EDIT_CALL,
    call
})

export const setCall = (call: call[]): any => ({
    type: SET_CALL,
    call
})

export const startRemoveCall = (id: string) => {
  return (dispatch: Dispatch<any>, getState: () => AppState) => {
    dispatch(removeCall(id))
  }
}

export const startEditCall = (call: Call) => {
  return (dispatch: Dispatch<any>, getState: () => AppState) => {
    dispatch(editCall(call))
  }
}

export const startUpdateCall = (call: Call[]) => {
  return (dispatch: Dispatch<any>, getState: () => AppState) => {
    dispatch(editCall(call))
  }
}
