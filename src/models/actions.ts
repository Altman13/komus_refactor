//import { Contact, Report, Contacts } from "./contact";
import { Contact, Contacts } from "./contact";

export const MAKE_CALL = "MAKE_CALL";
export const RECEIVE_CALL = "RECEIVE_CALL";
export const GET_CONTACTS = "GET_CONTACTS";
export const SET_FILTER_ON_CONTACTS = "SET_FILTER_ON_CONTACTS";

export interface MakeCallAction {
  type: typeof MAKE_CALL;
  id: number;
}

export interface ReceiveCallAction {
  type: typeof RECEIVE_CALL;
  contact: Contact;
}
export interface GetContactsAction {
  type: typeof GET_CONTACTS;
  contacts: Contacts;
}
export interface SetFilterOnContactsAction {
  type: typeof SET_FILTER_ON_CONTACTS;
  contact: Contact;
}

export type CallActionTypes =
  | ReceiveCallAction
  | MakeCallAction
  | GetContactsAction
  | SetFilterOnContactsAction

  export type AppActions = CallActionTypes;
