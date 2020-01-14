import  React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux'
import FormComponent from './components/FormComponent'
import { store } from './store';

ReactDOM.render(
<Provider store = {store}>
<FormComponent />
</Provider>,
document.getElementById('root')
)
