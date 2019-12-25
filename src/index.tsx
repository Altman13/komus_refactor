import * as React from 'react';
import * as ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { store } from './store';
import './App.css';

//import { RootState } from './reducers';
//import { Action } from 'redux-actions';


ReactDOM.render(
  <Provider store={store}>
  </Provider>,
  document.getElementById('root') as HTMLElement
);