import React from "react"
import { BrowserRouter as Router,
        Switch, Route, Redirect
} from "react-router-dom"
import  LoginComponent  from '../components/LoginComponent'
import FormComponent from "../components/FormComponent";
import  { DashBoardComponent }   from '../components/DashBoardComponent'
let user_group = JSON.parse(localStorage.getItem('user_group') || '{}');
import { UserFactory } from '../components/UserFactory'
let factory = new UserFactory();
let user = factory.getUserRole(parseInt(user_group));
console.log(user_group)
//let user = factory.getUserRole(parseInt('2'));
    // switch (user!.constructor.name) {
    //     case 'Guest':
    //         console.log('Guest')
    //         break;
    //     case 'Operator':
    //         console.log('Operator')
    //         break;
    //     case 'St_operator':
    //         console.log('St_operator')
    //         break;
    //     case 'Administrator':
    //         console.log('Administrator')
    //         break;
    //     default:
    //         break;
    // }
    var auth = true
    //const token = localStorage.getItem('token')
    if( auth ){
        auth = true
        console.log(auth)
    }
export function MainRouter() {
    return (
            <Router>
                <Switch>
                    <Route exact path="/" component={PrivateRoute} />
                    <Route path="/login" component={LoginComponent} />
                    { auth ? (<Route path="/main" component={FormComponent} />) :
                    (<Route path="/dashboard" component={PrivateRoute} />)}
                    { auth ? (<Route path="/dashboard" component={DashBoardComponent} />) :
                    (<Route path="/dashboard" component={PrivateRoute} />)}
                    <Route path="*" component={PrivateRoute} />
                </Switch>
            </Router>
        )
}
function PrivateRoute() {

    return (
        <Route
            render={() =>
                auth ? (
                    <Redirect to="/main"/>
                ) : (
                    <Redirect to="/login"/>
                )
            }
        />
    )
}