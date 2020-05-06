import { Contacts } from "./../models/contact"
import { CallActionTypes } from "./../models/actions"

const callsReducerDefaultState: Contacts = {
  contacts: [],
}

const CallReducer = (
  state = callsReducerDefaultState,
  action: CallActionTypes
) => {
  switch (action.type) {
    case "MAKE_CALL":
      return [...state.contacts, action.contacts]
    case "RECEIVE_CALL":
      return [...state.contacts, action.contact]
    default:
      return state
  }
}

export { CallReducer }
