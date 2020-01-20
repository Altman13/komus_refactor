import React from "react";
import MailSendComponent from "./MailSendComponent";
import { Button, Dialog, DialogActions, DialogTitle, TextField } from "@material-ui/core";
export class FormComponent extends React.Component {
  
  componentDidMount() {
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
        <br/> 
        <TextField
          id="multiline-flexible"
          multiline
        />
      </div>
    );
  }
}

export default FormComponent;
