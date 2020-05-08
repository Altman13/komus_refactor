import React from "react";
import ReactDOM from "react-dom";
import { Provider } from "react-redux";
import { store } from "./store";
import { BrowserRouter as Router, Switch, Route, Link } from "react-router-dom";
import LoginComponent from "./components/LoginComponent";
import FormComponent from "./components/FormComponent";
import { ResponsiveDrawer } from './components/DashBoardComponent'
import AuthExample from './components/auth_temp'

ReactDOM.render(
    <Provider store={store}>
        <Router>
            <Switch>
                <Route exact path="/" component={LoginComponent} />
                {/* <Route exact path="/" component={AuthExample} /> */}
                <Route path="/main" component={FormComponent} />
                <Route path="/dashboard" component={ResponsiveDrawer} />
            </Switch>
        </Router>
    </Provider>,

document.getElementById("root")
);
