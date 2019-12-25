import { CallModel } from '../models/CallModel';

export interface RootState {
  calls: RootState.CallState;
  router?: any;
}

export namespace RootState {
  export type CallState = CallModel[];
}
