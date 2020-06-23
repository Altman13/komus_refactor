import {
  AppActions,
  MAKE_CALL,
  RECEIVE_CALL
} from "./../models/actions";
import actionCreatorFactory from "typescript-fsa"
import { asyncFactory } from "typescript-fsa-redux-thunk"
import { AppState } from "../store"
const create = actionCreatorFactory()
const createAsync = asyncFactory<AppState>(create)
import { Dispatch } from "redux"

export const get_contacts = createAsync<any, any>(
  "GET_CONTACTS",
  async (params, dispatch) => {
    try {
      let resp = "";
      await fetch("http://localhost/komus_new/api/calls")
        .then((response) => {
          return response.json();
        })
        .then((data) => {
          resp = data;
        });
      return dispatch({ type: "GET_CONTACTS", contacts: resp })
    } catch (err) {
      console.log(err)
    }
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

export const send_mails = (email : string , id : number) => {
      fetch("http://localhost/komus_new/api/mail", {
      method: "POST",
      mode: "cors",
      cache: "no-cache",
      credentials: "same-origin",
      headers: {
        "Content-Type": "application/json",
      },
      redirect: "follow",
      referrerPolicy: "no-referrer",
    })
}

export const receive_calls = createAsync<any, any>(
  "RECEIVE_CALL",
  async (params, dispatch) => {
    try {
      let resp = "";
      await fetch("http://localhost/komus_new/api/calls", {
        method: "POST",
        mode: "cors", 
        cache: "no-cache", 
        credentials: "same-origin",
        headers: {
          "Content-Type": "application/json",
        },
        redirect: "follow", 
        referrerPolicy: "no-referrer",
      });
      return dispatch({ type: RECEIVE_CALL, contacts: resp })
    } catch (err) {
      console.log(err)
    }
  }
)