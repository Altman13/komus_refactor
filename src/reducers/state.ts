import { call } from '../models/call';

export interface RootState {
  calls: RootState.CallState;
  router?: any;
}

export namespace RootState {
  export type CallState = call[];
}
