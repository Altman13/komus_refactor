import { AppState } from './../store/index';
import actionCreatorFactory from "typescript-fsa";
import { asyncFactory } from "typescript-fsa-redux-thunk";
import { Contact } from "../models/contact";
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

const init = actionCreatorFactory('AppActions');
const createAsync = asyncFactory<AppState>(init);
const receiveCall = init<Contact>('RECEIVE_CALL');

export const rec_call = createAsync<any, any>(
	'receiveCall',
	async (params, dispatch) => {
		const url = `https://reqres.in/api/login`;
		const options: RequestInit = {
			method: 'POST',
			body: JSON.stringify(params),
			headers: {
				'Content-Type': 'application/json; charset=utf-8'
			}
		};
		const res = await fetch(url, options);
		if (!res.ok) {
			throw new Error(`Error ${res.status}: ${res.statusText}`);
		}
		dispatch(receiveCall);
		return res.json();
	}
);