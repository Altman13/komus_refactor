export interface Contact{
  id: number,
  name: string,
  fio_lpr: string,
  phone_lpr : number,
  mail_lpr?:string,
  comment?: string
}

  export enum Filter {
    SHOW_ALL = 'all',
    SHOW_RECALL= 'recall',
    SHOW_NORECALL = 'norecall',
    SHOW_FINISHCALL = 'finishcall'
  }
