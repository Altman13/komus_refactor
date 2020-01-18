import { Contact } from "./../models/contact"
import { MAKE_CALL, RECEIVE_CALL } from "./../models/actions"
import actionCreatorFactory from "typescript-fsa"
import { asyncFactory } from "typescript-fsa-redux-thunk"
import { AppState } from "../store"

const create = actionCreatorFactory(MAKE_CALL)
const createAsync = asyncFactory<AppState>(create)
const call_make = create<Contact>(MAKE_CALL)

export const rec_call = createAsync<any, any>(
  "MAKE_CALL",
  async (params, dispatch) => {
    try {
      //let response = await fetch("https://jsonplaceholder.typicode.com/users")
      let response = await fetch("http://localhost/react/php/komus_new/test.php")
      if (!response.ok) {
        throw new Error(response.statusText)
      }
      let contacts = await response.json()
      console.table(contacts)
      return dispatch({ type: 'MAKE_CALL', contact: contacts });
        } catch (err) {
      console.log(err)
    }
  }
)
