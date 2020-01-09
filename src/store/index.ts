import { Contact } from './../models/contact';
import { createStore, combineReducers, applyMiddleware } from "redux";
import thunk, { ThunkMiddleware } from "redux-thunk";
import { CallReducer } from "../reducers/calls";
import { AppActions } from "../models/actions";

import actionCreatorFactory from "typescript-fsa";
import { asyncFactory } from "typescript-fsa-redux-thunk";
interface State {
	contacts: Contact []
}
const initial: State = {
	contacts: []
}
// const create = actionCreatorFactory();
// const createAsync = asyncFactory<State>(create);

export const rootReducer = combineReducers({
	contacts: CallReducer
});

export type AppState = ReturnType<typeof rootReducer>;

export const store = createStore(
	rootReducer,
	applyMiddleware(thunk as ThunkMiddleware<AppState, AppActions>)
);
