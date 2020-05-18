import { Contacts, Contact} from "./../models/contact"
import { CallActionTypes } from "./../models/actions"
import { type } from "os"

const callsReducerDefaultState: Contacts = {
  contacts : []
}

const CallReducer = (
  state = callsReducerDefaultState,
  action: CallActionTypes
) => {
  switch (action.type) {
    case "GET_CONTACTS":
      return action.contacts
    case "MAKE_CALL":
    //console.log(state.contacts.filter(({ id }) => id !== action.id))
    return state.contacts.filter(({ id }) => id !== action.id)
    
    case "RECEIVE_CALL":
      return [...state.contacts, action.contact]
    default:
      return state
  }
}

export { CallReducer }
