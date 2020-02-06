enum ClubHomeCountry {
  England,
  Germany
}
interface IFootballClub {
  getName(): string | undefined;
  getHomeCountry(): ClubHomeCountry | undefined;
}
interface IFootballClubPrinter<T extends IFootballClub> {
  print: (x: T) => void;
}
class FootballClubPrinter<T extends IFootballClub>
  implements IFootballClubPrinter<T> {
  print(arg: T) {
    console.log(
      ` ${arg.getName()} is ` +
        `${this.IsEnglishTeam(arg)}` +
        ` an English football team.`
    );
  }
  IsEnglishTeam(arg: T): string {
    if (arg.getHomeCountry() == ClubHomeCountry.England) return "";
    else return "NOT";
  }
}

class FirstClass {
  id: number | undefined;
}
class SecondClass {
  name: string | undefined;
}
class GenericCreator<T> {
  create(arg1: { new (): T }): T {
    return new arg1();
  }
}

var creator1 = new GenericCreator<FirstClass>();
var firstClass: FirstClass = creator1.create(FirstClass);
var creator2 = new GenericCreator<SecondClass>();
var secondClass : SecondClass = creator2.create(SecondClass);


interface a {
    a: number;
    }
    interface ab {
    a: number;
    b: string;
    }
    interface abc {
    a: number;
    b: string;
    c: boolean;
    }

type abc_ab_a<T> = T extends abc ? [number, string, boolean] :
T extends ab ? [number, string] :
T extends a ? [number]
: never;

function getKeyAbc<T>(key: abc_ab_a<T>): string {
    let [...args] = key;
    let keyString = ":";
    for (let arg of args) {
    keyString += `${arg}:`
    }
    return keyString;
    }