import { Contact } from "./../models/contact";
import { createStore, combineReducers, applyMiddleware } from "redux";
import { composeWithDevTools } from "redux-devtools-extension";
import thunk, { ThunkMiddleware } from "redux-thunk";
import { CallReducer } from "../reducers/calls";
import { AppActions } from "../models/actions";

interface State {
  contacts: Contact[];
}

// const create = actionCreatorFactory();
// const createAsync = asyncFactory<State>(create);

export const rootReducer = combineReducers({
  contacts: CallReducer
});

export type AppState = ReturnType<typeof rootReducer>;

export const store = createStore(
  rootReducer,
  composeWithDevTools(
    applyMiddleware(thunk as ThunkMiddleware<AppState, AppActions>)
    // other store enhancers if any
  )
);
