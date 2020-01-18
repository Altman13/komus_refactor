import React from "react";
//import { MDBContainer, MDBInput, MDBBtn } from "mdbreact";
const mdbreact = require("mdbreact");
//const { MDBContainer, MDBInput, MDBBtn } = mdbreact;
import MailSendComponent from "./MailSendComponent";
import { buildRequestCreator } from "../utils";

export class FormComponent extends React.Component {
  componentDidMount() {
    //fetch("https://jsonplaceholder.typicode.com/todos/1")
    // fetch("http://localhost/react/php/komus_new/test.php")
    //   .then(response => response.json())
    //   .then(json => console.table(json));
  }
  render() {
    return (
      <div className="container-fluid">
        <input className="" placeholder="Организация" />
        <br />
        <input className="" placeholder="Фио ЛПР" />
        <br />
        <input className="" placeholder="Телефон ЛПР" />
        <br />
        <input className="" placeholder="Почта ЛПР" />
        <br />
        <input className="" placeholder="Контакты" />
        <br />

        <MailSendComponent />
        <input
          className=""
          type="button"
          value="Продолжить"
        />
      </div>
    );
  }
}

export default FormComponent;
