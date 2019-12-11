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
    fetch('/react/php/komus_new/test.php')
      .then(response => response.json())
      .then(json => console.log(json))
      console.log(json)
  }

  render() {
    return ( <div>
      Hello, React!
      </div>
    )
  }
};

ReactDOM.render( < HelloWorld / > , document.getElementById('root'));