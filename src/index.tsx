import  React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux'
import FormComponent from './components/FormComponent'
import HomePagePage from './components/HomeComponent'
import { store } from './store';

ReactDOM.render(
<Provider store = {store}>
<FormComponent />
<HomePagePage />
</Provider>,
document.getElementById('root')
)
