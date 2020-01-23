import  React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux'
//import FormComponent from './components/FormComponent'
import Login from './components/LoginComponent';
import LoginTemp from './components/TempComponent';
import HomePagePage from './components/HomeComponent'
import FormComponent from './components/FormComponent'
import { store } from './store';

ReactDOM.render(
<Provider store = {store}>
<LoginTemp classes/>
<FormComponent classes/>
</Provider>,

document.getElementById('root')
)
