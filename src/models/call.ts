
// export interface call {
//   id: string;
//   fio_lpr: string;
//   mail_lpr:string;
//   name: string;
//   comment: string;
//}
// "Организация"
// "Фио ЛПР"
// "Телефон ЛПР"
// "Почта ЛПР"
// "Контакты"
// export interface phone {
//   phone: number,
// }
export interface contact{
  id: number,
  name: string,
  fio_lpr: string,
  phone_lpr : number,
  mail_lpr?:string,
  comment?: string
}
export namespace Call {
  export enum Filter {
    SHOW_ALL = 'all',
    SHOW_RECALL= 'recall',
    SHOW_NORECALL = 'norecall',
    SHOW_FINISHCALL = 'finishcall'
  }
}
