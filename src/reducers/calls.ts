import { Contact} from "./../models/contact"
import { CallActionTypes } from "./../models/actions"

const callsReducerDefaultState: Contact[] = []

export const CallReducer = (
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

    default:
      return state
  }
}
