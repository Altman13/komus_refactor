/** TodoMVC model definitions **/

export interface CallModel {
  id: number;
  text: string;
}

export namespace CallModel {
  export enum Filter {
    SHOW_ALL = 'all',
    SHOW_RECALL= 'recall',
    SHOW_NORECALL = 'norecall'
    SHOW_FINISHCALL = 'finishcall'
  }
}
