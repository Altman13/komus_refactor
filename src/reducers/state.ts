import { Contact } from '../models/contact';

export interface RootState {
  calls: RootState.CallState;
  router?: any;
}

export namespace RootState {
  export type CallState = Contact[];
}
