enum Users {
  operator,
  st_operator,
  administrator,
  undefined
}
interface IUsers {
  Category: Users;
  printDetails(): void;
}

abstract class User implements IUsers {
  Category: Users;
  private user_role: number;
  constructor(user_role: number) {
    this.user_role = user_role;
    this.Category = Users.undefined;
  }
  printDetails(): void {
    // console.log(`User : `);
  }
}
 export class Opertator extends User {
  constructor(user_role: number) {
    super(user_role);
    this.Category = Users.operator;
  }
}
class St_operator extends User {
  constructor(user_role: number) {
    super(user_role);
    this.Category = Users.st_operator;
  }
}
class Administrator extends User {
  constructor(user_role: number) {
    super(user_role);
    this.Category = Users.administrator;
  }
}
class UserFactory {
  getUserRole(user_role: number) : IUsers | undefined {
    if (user_role == 1) {
      return new Opertator(user_role);
    }
    if (user_role == 2) {
      return new St_operator(user_role);
    }
    if (user_role == 3) {
      return new Administrator(user_role);
    }
  }
}

let factory = new UserFactory();
let user = factory.getUserRole(1);
user!.printDetails();
