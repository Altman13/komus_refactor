import { CallActionTypes } from "./../models/actions"
import { Contact } from "../models"

const callsReducerDefaultState: Contact[] = []

const CallReducer = (
  state = callsReducerDefaultState,
  action: CallActionTypes
): Contact[] => {
  switch (action.type) {
    case "MAKE_CALL":
      return [...state, action.contact]
    case "RECEIVE_CALL":
      return [...state, action.contact]
    default:
      return state
  }
}

export { CallReducer }
