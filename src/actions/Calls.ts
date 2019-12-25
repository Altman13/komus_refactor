import { handleActions } from "redux-actions";
import { RootState } from "./state";
import { CallActions } from "./calls";
import { CallModel } from "../models";
const initialState: RootState.CallState = [
  {
    id: 1,
    text: ""
  }
];

export const callReducer = handleActions<RootState.CallState, CallModel>(
  {
    [CallActions.Type.ADD_CALL]: (state, action) => {
      if (action.payload && action.payload.text) {
        return [
          {
            id: state.reduce((max, call) => Math.max(call.id || 1, max), 0) + 1,
            completed: false,
            text: action.payload.text
          },
          ...state
        ];
      }
      return state;
    },
    [CallActions.Type.DELETE_CALL]: (state, action) => {
      return state.filter(call => call.id !== (action.payload as any));
    },
    [CallActions.Type.EDIT_CALL]: (state, action) => {
      return state.map(call => {
        if (!call || !action || !action.payload) {
          return call;
        }
        return (call.id || 0) === action.payload.id
          ? { ...call, text: action.payload.text }
          : call;
      });
    }
  },
  initialState
);
