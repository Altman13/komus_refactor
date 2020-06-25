import { Dispatch } from "redux"
import actionCreatorFactory from "typescript-fsa"
import { asyncFactory } from "typescript-fsa-redux-thunk"
import { AppState } from "../store"
import { AppActions, MAKE_CALL, RECEIVE_CALL } from "./../models/actions";
import { ajaxAction } from './../servicies'

const create = actionCreatorFactory()
const createAsync = asyncFactory<AppState>(create)

export const get_contacts = createAsync<any, any>(
  "GET_CONTACTS",
  async (params, dispatch) => {
    const url: string = 'calls'
    const data: string = ''
    let resp = ''
    resp = await ajaxAction(url, 'GET', data)
    return dispatch({ type: "GET_CONTACTS", contacts: resp })
  }
)
function makeCall(id: number): AppActions {
  return {
    type: MAKE_CALL,
    id,
  }
}
export const make_calls = (id: number) => {
  return (dispatch: Dispatch<AppActions>) => {
    dispatch(makeCall(id))
  }
}
export async function send_mails (data: any) {
    const url: string = 'mail'
    const data_for_send = data
    let resp = ''
    resp = await ajaxAction(url, 'GET', data_for_send)
    return resp
}

export const receive_calls = createAsync<any, any>(
  "RECEIVE_CALL",
  async (params, dispatch) => {
    const url: string = 'contacts'
    const data: string = ''
    let resp = ''
    resp = await ajaxAction(url, 'POST', data)
    return dispatch({ type: RECEIVE_CALL, contacts: resp })
  }
)
