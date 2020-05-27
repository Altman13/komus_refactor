import { AppActions, MAKE_CALL , RECEIVE_CALL} from './../models/actions';
import actionCreatorFactory from "typescript-fsa";
import { asyncFactory } from "typescript-fsa-redux-thunk";
import { AppState } from "../store";
const create = actionCreatorFactory();
const createAsync = asyncFactory<AppState>(create);
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
          resp = data
        });
      return dispatch({ type: "GET_CONTACTS", contacts: resp });
    } catch (err) {
      console.log(err);
    }
  }
)
function makeCall (id: number): AppActions {
  return {
    type: MAKE_CALL,
  id
  }
}
export const make_calls = (id: number) => {
  return (dispatch: Dispatch<AppActions>) => {
    dispatch(makeCall(id));
  }
}
export const receive_calls =createAsync<any, any>(
    "RECEIVE_CALL",
    async (params, dispatch) => {
      try {
        let resp=''
        await fetch("http://localhost/komus_new/api/calls", {
            method: 'POST', // *GET, POST, PUT, DELETE, etc.
            mode: 'cors', // no-cors, *cors, same-origin
            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            credentials: 'same-origin', // include, *same-origin, omit
            headers: {
              'Content-Type': 'application/json'
          // 'Content-Type': 'application/x-www-form-urlencoded',
            },
            redirect: 'follow', // manual, *follow, error
            referrerPolicy: 'no-referrer', // no-referrer, *client
            //TODO: передача данных
            //body: JSON.stringify(data) // body data type must match "Content-Type" header
        });
        return dispatch({ type: "RECEIVE_CALL", contacts: resp });
      } catch (err) {
        console.log(err);
      }
    }
  )
  