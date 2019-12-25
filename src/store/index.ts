import { createStore, combineReducers, applyMiddleware } from "redux";
import thunk, { ThunkMiddleware } from "redux-thunk";
import { callReducer } from "../reducers";
import { AppActions } from "../actions";

export const rootReducer = combineReducers({
  calls: callReducer
});

export type AppState = ReturnType<typeof rootReducer>;

export const store = createStore(
  rootReducer,
  applyMiddleware(thunk as ThunkMiddleware<AppState, AppActions>)
);
