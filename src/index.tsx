import React from "react";
import ReactDOM from "react-dom";
import { Provider } from "react-redux";
import { store } from "./store";
import { BrowserRouter as Router, Switch, Route, Link, Redirect } from "react-router-dom";
import LoginComponent from "./components/LoginComponent";
import FormComponent from "./components/FormComponent";
import { ResponsiveDrawer } from './components/DashBoardComponent'
import AuthExample from './components/auth_temp'

ReactDOM.render(
    <Provider store={store}>
        <Router>
            <Switch>
                {<Route exact path="/" component={PrivateRoute} />}
                <Route path="/login" component={LoginComponent} />
                {<Route path="/main" component={FormComponent} />}
                <Route path="/dashboard" component={ResponsiveDrawer} />
            </Switch>
        </Router>
    </Provider>,

document.getElementById("root")
)
function PrivateRoute() {
let token=localStorage.getItem('token')
console.log('token :>> ', token);
const auth =true
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