import actionCreatorFactory from 'typescript-fsa'
import { asyncFactory } from 'typescript-fsa-redux-thunk'
import { AppState } from '../store'
import { MAKE_CALL, RECEIVE_CALL, GET_CONTACTS } from './../models/actions'
import { ajaxAction } from './../services'

const create = actionCreatorFactory()
const createAsync = asyncFactory<AppState>( create )

export const get_contacts = createAsync<any, any>(
  "GET_CONTACTS",
  async ( params, dispatch ) => {
    const url: string = 'calls'
    const resp = await ajaxAction( url, 'GET' )
    
    return dispatch({ type: GET_CONTACTS, contacts: resp })
  }
)

export const receive_calls = createAsync<any, any>(
  "RECEIVE_CALL",
  async ( params, dispatch ) => {
    const url: string = 'contacts'
    const method : string = 'POST'
    const resp = await ajaxAction( url, method )
    return dispatch({ type: RECEIVE_CALL, contacts: resp })
  }
)

export const make_calls = createAsync<any, any>(
  "MAKE_CALL",
  async ( contact, dispatch ) => {
    const url : string = 'contact'
    const method : string = 'POST' 
    const { id } = contact
    await ajaxAction( url, method, contact )
    return dispatch({ type: MAKE_CALL, id })
  }
)

export async function send_mails ( url: string, method: string, data: any ) {
    const resp = await ajaxAction( url, method, data )
    return resp
}