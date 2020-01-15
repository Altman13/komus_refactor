import { Contact } from './../models/contact';
import { MAKE_CALL, RECEIVE_CALL } from './../models/actions';
// import { CallActionTypes } from "./../models/actions";

// import { RECEIVE_CALL, MAKE_CALL } from "../models/actions";
// export const makeCall = (contact: Contact): CallActionTypes => ({
//   type: MAKE_CALL,
//   contact
// });
// export const receiveCall = (contact: Contact): CallActionTypes => ({
//   type: RECEIVE_CALL,
//   contact
// });
import actionCreatorFactory from "typescript-fsa";
import { asyncFactory } from "typescript-fsa-redux-thunk";
import { AppState } from "../store";

const create = actionCreatorFactory(MAKE_CALL);
const createAsync = asyncFactory<AppState>(create);

const call_make = create<Contact>(MAKE_CALL);

export const rec_call = createAsync<any, any>(
  "CALL_MAKE",
  async (params, dispatch) => {
    const url = `https://jsonplaceholder.typicode.com/users`;
    const options: RequestInit = {
      method: "POST",
      body: JSON.stringify(params),
      headers: {
        "Content-Type": "application/json; charset=utf-8"
      }
    };
    const res = await fetch(url, options);
    if (!res.ok) {
      throw new Error(`Error ${res.status}: ${res.statusText}`);
    }
    dispatch(call_make);
    return res.json();
  }
);

// import { createAsyncAction } from 'redux-promise-middleware-actions';

// export const fetchData = createAsyncAction('FETCH_DATA', async () => {
//   const res = await fetch(`https://reqres.in/api/login`);
//   return res.json();
// });
