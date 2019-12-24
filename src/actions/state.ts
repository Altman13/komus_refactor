import { CallModel } from '../models';

export interface RootState {
  calls: RootState.CallState;
  router?: any;
}

export namespace RootState {
  export type CallState = CallModel[];
}
