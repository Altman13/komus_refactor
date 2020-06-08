import React from "react";
import ReactDOM from "react-dom";
import { Provider } from "react-redux";
import { store } from "./store";
import { MainRouter } from "./router";

ReactDOM.render(
    <Provider store={store}>
        <MainRouter/>
    </Provider>,

document.getElementById("root")
)
