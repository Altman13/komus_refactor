import { call } from "./call";

// action strings
export const ADD_CALL = "ADD_CALL";
export const EDIT_CALL = "EDIT_CALL";
export const REMOVE_CALL = "REMOVE_CALL";
export const SET_CALL = "SET_CALL";

export interface AddCallAction {
    type: typeof SET_CALL;
    call: call[];
}

export interface EditCallAction {
    type: typeof EDIT_CALL;
    call: call;
}

export interface RemoveCallAction {
    type: typeof REMOVE_CALL;
    id: string;
}

export interface SetCallAction {
    type: typeof ADD_CALL;
    call: call;
}

export type CallActionTypes =
    | SetCallAction
    | EditCallAction
    | RemoveCallAction
    | AddCallAction;

export type AppActions = CallActionTypes;