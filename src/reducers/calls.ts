import { Contact} from "./../models/contact"
import { CallActionTypes } from "./../models/actions"

const callsReducerDefaultState: Contact[] = []

const CallReducer = (
  state = callsReducerDefaultState,
  action: CallActionTypes
) => {
  switch (action.type) {
    case "GET_CONTACTS":
      return action.contacts
    case "MAKE_CALL":
    return state.filter(({ id }) => id !== action.id)
    case "RECEIVE_CALL":
      return [...state, action.contact]
    case "SEND_MAIL" :
      return [...state, action.contact]
    default:
      return state
  }
}

export { CallReducer }
