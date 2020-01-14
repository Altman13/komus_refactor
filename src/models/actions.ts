
//import { MAKE_CALL, RECEIVE_CALL } from './../components/test';
import { Contact } from "./contact";
;

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

