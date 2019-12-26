import { CallActionTypes } from './../models/actions';
import { call } from '../models';

const callsReducerDefaultState: call[] = [];

const callReducer = (
  state = callsReducerDefaultState,
  action: CallActionTypes
): call[] => {
  switch (action.type) {
    case "ADD_CALL":
      return [...state, action.call];
    case "REMOVE_CALL":
      return state.filter(({ id }) => String(id) !== action.id);
    case "EDIT_CALL":
      return state.map(call => {
        if (call.id === action.call.id) {
          return {
            ...call,
            ...action.call
          };
        } else {
          return call;
        }
      });
    case "SET_CALLS":
      return action.calls;
    default:
      return state;
  }
};

export { callReducer };