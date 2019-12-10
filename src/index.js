import React from 'react';
import ReactDOM from 'react-dom';

class HelloWorld extends React.Component {
  constructor() {
    super();
    this.state = {
      data: []
    };
  }

  componentDidMount() {
    fetch('https://jsonplaceholder.typicode.com/todos/10')
      .then(response => response.json())
      .then(json => console.log(json))
  }

  render() {
    return ( <div>
      Hello, React!
      </div>
    )
  }
};

ReactDOM.render( < HelloWorld / > , document.getElementById('root'));