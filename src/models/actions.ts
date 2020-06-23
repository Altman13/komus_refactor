import { Contact, Report, Contacts } from "./contact";

export const MAKE_CALL = "MAKE_CALL";
export const RECEIVE_CALL = "RECEIVE_CALL";
export const GET_CONTACTS = "GET_CONTACTS";
export const SET_FILTER_ON_CONTACTS = "SET_FILTER_ON_CONTACTS";
export const GET_REPORTS_BY_OPERATOR = "GET_REPORTS_BY_OPERATOR";
export const GET_REPORTS_BY_DATE = "GET_REPORTS_BY_DATE";
export const GET_FULL_REPORT = "GET_FULL_REPORT";
export const GET_ADDITIONAL_INFO_BY_CONTACT = "GET_ADDITIONAL_INFO_BY_CONTACT";
export const SET_ADDITIONAL_INFO_BY_CONTACT = "SET_ADDITIONAL_INFO_BY_CONTACT";
export const SEARCH_INFO = "SEARCH_INFO";
export const OPEN_SESSION = "OPEN_SESSION";
export const CLOSE_SESSION = "CLOSE_SESSION";
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
export interface GetReportByOperatorAction {
  type: typeof GET_REPORTS_BY_OPERATOR;
  report: Report;
}
export interface GetReportByDateAction {
  type: typeof GET_REPORTS_BY_DATE;
  report: Report;
}
export interface GetFullReportAction {
  type: typeof GET_FULL_REPORT;
  report: Report;
}
export interface GetInfoByContactAction {
  type: typeof GET_ADDITIONAL_INFO_BY_CONTACT;
  contact: Contact;
}
export interface SetlInfoByContactAction {
  type: typeof SET_ADDITIONAL_INFO_BY_CONTACT;
  contact: Contact;
}
//TODO : добавить возможность работы со справочниками
export interface SearchInfoAction {
  type: typeof SEARCH_INFO;
  contact?: Contact;
}

export type CallActionTypes =
  | ReceiveCallAction
  | MakeCallAction
  | GetContactsAction
  | SetFilterOnContactsAction
  | GetReportByOperatorAction
  | GetReportByDateAction
  | GetFullReportAction
  | GetInfoByContactAction
  | SetlInfoByContactAction
  | SearchInfoAction

export type AppActions = CallActionTypes;
