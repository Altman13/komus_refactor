export enum Users {
  guest,
  operator,
  st_operator,
  administrator
}
interface IUsers {
  Category: Users
}
abstract class User implements IUsers {
  Category: Users
  private user_role: number
  constructor( user_role: number ) {
    this.user_role = user_role
    this.Category = Users.guest
  }
}
export class Guest extends User {
  constructor( user_role: number ) {
    super( user_role )
    this.Category = Users.guest
  }
}
export class Operator extends User {
  constructor( user_role: number ) {
    super( user_role )
    this.Category = Users.operator
  }
}
class St_operator extends User {
  constructor( user_role: number ) {
    super( user_role )
    this.Category = Users.st_operator
  }
}
class Administrator extends User {
  constructor( user_role: number ) {
    super( user_role )
    this.Category = Users.administrator
  }
}
export class UserFactory {
  getUserRole( user_role: number ) : IUsers | undefined {
    if( user_role == 0 ) {
      return new Guest( user_role )
    }
    if ( user_role == 1 ) {
      return new Operator( user_role )
    }
    if ( user_role == 2 ) {
      return new St_operator( user_role )
    }
    if ( user_role == 3 ) {
      return new Administrator( user_role )
    }
  }
}
