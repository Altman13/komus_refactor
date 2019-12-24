import * as React from 'react';
import * as ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import { createStore } from 'redux';
import { RootState } from './store';
import './App.css';

const store = createStore<RootState>({
  languageName: 'TypeScript',
});

ReactDOM.render(
  <Provider store={store}>
  </Provider>,
  document.getElementById('root') as HTMLElement
);