import React from "react";
import "./App.css";
import { Provider } from "react-redux";
import { store } from "./store/";

const App: React.FC = () => {
    
};

export default App;
export interface AppProps {
    
}
 
export interface AppState {
    
}
 
class App extends React.Component<AppProps, AppState> {
    constructor(props: AppProps) {
        super(props);
        this.state = { :  };
    }
    render() { 
        return ( return <Provider store={store}></Provider>; );
    }
}
 
export default App;