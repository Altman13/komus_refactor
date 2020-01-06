import { contact } from "./call";

// action strings
// export const ADD_CALL = "ADD_CALL";
// export const EDIT_CALL = "EDIT_CALL";
// export const REMOVE_CALL = "REMOVE_CALL";
// export const SET_CALLS = "SET_CALLS";

export const MAKE_CALL = "MAKE_CALL"
export const RECEIVE_CALL ="RECEIVE_CALL"

// export interface AddCallAction {
//     type: typeof SET_CALLS;
//     contact: contact[];
// }

// export interface EditCallAction {
//     type: typeof EDIT_CALL;
//     contact: contact;
// }

// export interface RemoveCallAction {
//     type: typeof REMOVE_CALL;
//     id: string;
// }

// export interface SetCallAction {
//     type: typeof ADD_CALL;
//     contact: contact;
// }

export interface ReceiveCallAction {
    type: typeof RECEIVE_CALL;
    contact: contact;
}
export interface MakeCallAction {
    type: typeof MAKE_CALL;
    contact: contact;
}

export type CallActionTypes =
    // | SetCallAction
    // | EditCallAction
    // | RemoveCallAction
    // | AddCallAction
    ReceiveCallAction | MakeCallAction

export type AppActions = CallActionTypes;