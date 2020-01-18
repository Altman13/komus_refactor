import { Contact } from "./../models/contact"
import { MAKE_CALL, RECEIVE_CALL } from "./../models/actions"
import actionCreatorFactory from "typescript-fsa"
import { asyncFactory } from "typescript-fsa-redux-thunk"
import { AppState } from "../store"

const create = actionCreatorFactory(MAKE_CALL)
const createAsync = asyncFactory<AppState>(create)
const call_make = create<Contact>(MAKE_CALL)

export const rec_call = createAsync<any, any>(
  "CALL_MAKE",
  async (params, dispatch) => {
    try {
      let response = await fetch("https://jsonplaceholder.typicode.com/users")
      if (!response.ok) {
        throw new Error(response.statusText)
      }
      let body = await response.json()
      console.table(body)
      return dispatch(call_make)
    } catch (err) {
      console.log(err)
    }
  }
)
