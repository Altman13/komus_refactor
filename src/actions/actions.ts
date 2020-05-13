import actionCreatorFactory from "typescript-fsa";
import { asyncFactory } from "typescript-fsa-redux-thunk";
import { AppState } from "../store";

const create = actionCreatorFactory();
const createAsync = asyncFactory<AppState>(create);
//const call_make = create<Contact>(MAKE_CALL)

export const rec_call = createAsync<any, any>(
  "MAKE_CALL",
  async (params, dispatch) => {
    try {
      // let response = await fetch("http://localhost/komus_new/api/calls")
      // if (!response.ok) {
      //   throw new Error(response.statusText)
      // }
      // let contacts = await response.json()
      let resp=''
      await fetch("http://localhost/komus_new/api/calls")
        .then((response) => {
          return response.json();
        })
        .then((data) => {
          resp =data
        });
      return dispatch({ type: "MAKE_CALL", contacts: resp });
    } catch (err) {
      console.log(err);
    }
  }
);
