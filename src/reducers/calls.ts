import { Contact} from "./../models/contact"
import { CallActionTypes } from "./../models/actions"

let spinner_visible:boolean =false
const callsReducerDefaultState = { Contact : [], spinner_visible }
export const CallReducer = (
  state = callsReducerDefaultState,
  action: CallActionTypes
) => {
  switch (action.type) {
    case "GET_CONTACTS":
      return action.contacts
    case "MAKE_CALL":
    return state.Contact.filter(({ id }) => id !== action.id)
    case "RECEIVE_CALL":
      return [...state.Contact, action.contact]
    case "SPINNER_ACTION":
        return { ...state, spinner_visible: action.is_visible }
    default:
      return state
  }
}
