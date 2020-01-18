export interface Contact{
  id: number,
  name: string,
  fio: string,
  phone : number,
  email?:string,
  comment?: string
}

  export enum Filter {
    SHOW_ALL = 'all',
    SHOW_RECALL= 'recall',
    SHOW_NORECALL = 'norecall',
    SHOW_FINISHCALL = 'finishcall'
  }
