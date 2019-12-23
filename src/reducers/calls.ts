import { handleActions } from 'redux-actions';
import { RootState } from './state';
import { CallActions } from '../actions/calls';
import { CallModel } from '../models';

const initialState: RootState.CallState = [
  {
    id: 1,
    text: 'Use Redux',
    completed: false
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
      return state.filter((call) => call.id !== (action.payload as any));
    },
    [CallActions.Type.EDIT_CALL]: (state, action) => {
      return state.map((call) => {
        if (!call || !action || !action.payload) {
          return call;
        }
        return (call.id || 0) === action.payload.id ? { ...call, text: action.payload.text } : call;
      });
    },
    [CallActions.Type.COMPLETE_CALL]: (state, action) => {
      return state.map((call) =>
        call.id === (action.payload as any) ? { ...call, completed: !call.completed } : call
      );
    },
    [CallActions.Type.COMPLETE_ALL]: (state, action) => {
      return state.map((call) => ({ ...call, completed: true }));
    },
    [CallActions.Type.CLEAR_COMPLETED]: (state, action) => {
      return state.filter((call) => call.completed === false);
    }
  },
  initialState
);
