
//import { make_call } from './actions';
import { MAKE_CALL, AppActions, MakeCallAction } from './../models/actions';
import actionCreatorFactory from "typescript-fsa";
import { asyncFactory } from "typescript-fsa-redux-thunk";
import { AppState } from "../store";
const create = actionCreatorFactory();
const createAsync = asyncFactory<AppState>(create);
//const call_make = create<Contact>(MAKE_CALL)
import { Dispatch } from "redux";

export const get_contacts = createAsync<any, any>(
  "GET_CONTACTS",
  async (params, dispatch) => {
    try {
      let resp=''
      await fetch("http://localhost/komus_new/api/calls")
        .then((response) => {
          return response.json();
        })
        .then((data) => {
          resp =data
        });
      return dispatch({ type: "GET_CONTACTS", contacts: resp });
    } catch (err) {
      console.log(err);
    }
  }
)
export const makeCall = (id: number): AppActions => ({
  type: MAKE_CALL,
  id
});
export const make_calls = (id: number) => {
  return (dispatch: Dispatch<AppActions>, getState: () => AppState) => {
    dispatch(makeCall(id));
  }
}
