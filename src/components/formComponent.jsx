import React from "react";
import { MDBContainer, MDBInput, MDBBtn } from "mdbreact";
import MailSendComponent from "./MailSendComponent";

class FormComponent extends React.Component {

render() {

  return (
    <MDBContainer>
        <MDBInput
            material
            containerClassName="mb-2 mt-0"
            label="Организация"/>
        <MDBInput
            material
            containerClassName="mb-2 mt-0"
            label="Фио ЛПР"/>    
        <MDBInput
            material
            containerClassName="mb-2 mt-0"
            label="Телефон ЛПР"/>    
        <MDBInput
            material
            containerClassName="mb-2 mt-0"
            label="Почта ЛПР"/>    
        <MDBInput
            material
            containerClassName="mb-2 mt-0"
            label="Контакты"/>    
                <div style={{ display: "flex" }}>
        <MailSendComponent/>
        <MDBBtn outline color="success" style={{ marginLeft: "auto", float: "right" }}>Продолжить</MDBBtn>
        </div>
        <MDBInput type="textarea" label="Комментарий оператора" rows="5" />
      </MDBContainer>
    );
  }
}
export default FormComponent;
