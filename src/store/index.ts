import { createStore, combineReducers, applyMiddleware } from "redux";
import thunk, { ThunkMiddleware } from "redux-thunk";
import  { CallReducer }  from "../reducers/calls";
import { AppActions } from "../models/actions";

import actionCreatorFactory from 'typescript-fsa';
import { asyncFactory } from 'typescript-fsa-redux-thunk';
interface State {
	title: string;
	//userToken: UserToken;
	loggingIn?: boolean;
	//error?: CustomError;
}
const createAsync = asyncFactory<State>(create);


export const rootReducer = combineReducers({
  calls: CallReducer
});

export type AppState = ReturnType<typeof rootReducer>;

export const store = createStore(
  rootReducer,
  applyMiddleware(thunk as ThunkMiddleware<AppState, AppActions>)
);
