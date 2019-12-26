
export interface call {
  id: string;
  fio_lpr: string;
  mail_lpr:string;
  name: string;
  comment: string;
}

export namespace Call {
  export enum Filter {
    SHOW_ALL = 'all',
    SHOW_RECALL= 'recall',
    SHOW_NORECALL = 'norecall',
    SHOW_FINISHCALL = 'finishcall'
  }
}
