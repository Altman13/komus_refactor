import React from 'react';
import ReactDOM from 'react-dom';
import FormComponent from './components/FormComponent'

import "@fortawesome/fontawesome-free/css/all.min.css";
import "bootstrap-css-only/css/bootstrap.min.css";
import "mdbreact/dist/css/mdb.css";


class HelloWorld extends React.Component {
  constructor() {
    super();
    this.state = {
      data: []
    };
  }
  
  componentDidMount() {
    fetch('/react/php/komus_new/test.php')
      .then( response => response.json() )
      // .then( json => console.table(json) )
  }

  render() {
    return ( <div>
      Тестовое название проекта
      <FormComponent/>
      </div>
    )
  }
};

ReactDOM.render( < HelloWorld / > , document.getElementById('root'));