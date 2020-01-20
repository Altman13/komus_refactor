import { Contact, Report } from "./contact"

export const MAKE_CALL = "MAKE_CALL"
export const RECEIVE_CALL = "RECEIVE_CALL"
export const GET_ALL_CONTACTS = "GET_ALL_CONTACTS"
export const SET_FILTER_ON_CONTACTS = "SET_FILTER_ON_CONTACTS"
export const GET_REPORTS_BY_OPERATOR = "GET_REPORTS_BY_OPERATOR"
export const GET_REPORTS_BY_DATE = "GET_REPORTS_BY_DATE"
export const GET_FULL_REPORT = "GET_FULL_REPORT"
export const GET_ADDITIONAL_INFO_BY_CONTACT = "GET_ADDITIONAL_INFO_BY_CONTACT"
export const SET_ADDITIONAL_INFO_BY_CONTACT = "SET_ADDITIONAL_INFO_BY_CONTACT"
export const SEARCH_INFO = "SEARCH_INFO"

export interface MakeCallAction {
  type: typeof MAKE_CALL
  contact: Contact
}
export interface ReceiveCallAction {
  type: typeof RECEIVE_CALL
  contact: Contact
}
export interface GetAllContacts {
  type: typeof GET_ALL_CONTACTS
  contact: Contact
}
export interface SetFilterOnContacts {
  type: typeof SET_FILTER_ON_CONTACTS
  contact: Contact
}
export interface GetReportByOperator {
  type: typeof GET_REPORTS_BY_OPERATOR
  report: Report
}
export interface GetReportByDate {
  type: typeof GET_REPORTS_BY_DATE
  report: Report
}
export interface GetFullReport {
  type: typeof GET_FULL_REPORT
  report: Report
}
export interface GetAdditionalInfoByContact {
  type: typeof GET_ADDITIONAL_INFO_BY_CONTACT
  contact: Contact
}
export interface SetAdditionalInfoByContact {
  type: typeof SET_ADDITIONAL_INFO_BY_CONTACT
  contact: Contact
}
//TODO : добавить возможность работы со справочниками
export interface SearchInfo {
  type: typeof SEARCH_INFO
  contact?: Contact
}
export type CallActionTypes = ReceiveCallAction | MakeCallAction
export type AppActions = CallActionTypes

