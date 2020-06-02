import React from "react";
import ReactDOM from "react-dom";
import { Provider } from "react-redux";
import { store } from "./store";
import { BrowserRouter as Router, Switch, Route, Link, Redirect } from "react-router-dom";
import LoginComponent from "./components/LoginComponent";
import FormComponent from "./components/FormComponent";
import { DashBoardComponent }  from './components/DashBoardComponent'
import { UserFactory } from './components/UserFactory'

let user_group = JSON.parse(localStorage.getItem('user_group') || '{}');
let factory = new UserFactory();
let user = factory.getUserRole(parseInt(user_group));

    switch (user!.constructor.name) {
        case 'Guest':
            console.log('Guest')
            break;
        case 'Operator':
            console.log('Operator')
            break;
        case 'St_operator':
            console.log('St_operator')
            break;
        case 'Administrator':
            console.log('Administrator')
            break;
        default:
            break;
    }

ReactDOM.render(
    <Provider store={store}>
        <Router>
            <Switch>
                {<Route exact path="/" component={PrivateRoute} />}
                <Route path="/login" component={LoginComponent} />
                {<Route path="/main" component={FormComponent} />}
                <Route path="/dashboard" component={DashBoardComponent} />
            </Switch>
        </Router>
    </Provider>,

document.getElementById("root")
)
function PrivateRoute() {
    if(user_group){
        var auth =true
    }
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