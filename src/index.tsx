import  React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux'
//import FormComponent from './components/FormComponent'
import LoginComponent from './components/LoginComponent';
import HomePagePage from './components/HomeComponent'
import { store } from './store';

ReactDOM.render(
<Provider store = {store}>
<LoginComponent />
</Provider>,
document.getElementById('root')
)
