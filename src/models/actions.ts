import { Contact } from "./contact";

export const MAKE_CALL = "MAKE_CALL";
export const RECEIVE_CALL = "RECEIVE_CALL";

export interface ReceiveCallAction {
  type: typeof RECEIVE_CALL;
  contact: Contact;
}
export interface MakeCallAction {
  type: typeof MAKE_CALL;
  contact: Contact;
}
export type CallActionTypes = ReceiveCallAction | MakeCallAction;
export type AppActions = CallActionTypes;
// const create = actionCreatorFactory('examples');
/** The typescript-fsa-redux-thunk async action creator factory function */
// const createAsync = asyncFactory<State>(create);
// /** The typescript-fsa action creator factory function */
// const create = actionCreatorFactory('examples');

// /** The typescript-fsa-redux-thunk async action creator factory function */
// const createAsync = asyncFactory<State>(create);

// /** Normal synchronous action */
// const changeTitle = create<string>('Change the title');

// /** The asynchronous login action; Error type is optional */
// const login = createAsync<LoginParams, UserToken, CustomError>(
// 	'Login',
// 	async (params, dispatch) => {
// 		const url = `https://reqres.in/api/login`;
// 		const options: RequestInit = {
// 			method: 'POST',
// 			body: JSON.stringify(params),
// 			headers: {
// 				'Content-Type': 'application/json; charset=utf-8'
// 			}
// 		};
// 		const res = await fetch(url, options);
// 		if (!res.ok) {
// 			throw new CustomError(`Error ${res.status}: ${res.statusText}`);
// 		}

// 		dispatch(changeTitle('You are logged-in'));

// 		return res.json();
// 	}
// );