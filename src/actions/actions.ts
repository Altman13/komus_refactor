import { Contact } from "../models/contact";
import { AppActions } from "./../models/actions";
import { RECEIVE_CALL, MAKE_CALL } from "../models/actions";

export const makeCall = (contact: Contact): AppActions => ({
  type: MAKE_CALL,
  contact
});
export const receiveCall = (contact: Contact): AppActions => ({
  type: RECEIVE_CALL,
  contact
});

