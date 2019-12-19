import { CallModel } from 'app/models';

export interface RootState {
  calls: RootState.CallState;
  router?: any;
}

export namespace RootState {
  export type CallState = CallModel[];
}
