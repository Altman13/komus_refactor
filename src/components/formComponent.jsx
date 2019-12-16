import React from "react";
import { MDBContainer, MDBInputGroup } from "mdbreact";
import { MDBInput } from 'mdbreact';
import { MDBBtn } from "mdbreact";

class FormComponent extends React.Component {
  render() {
    return (
    <MDBContainer>
        <MDBInputGroup
            material
            containerClassName="mb-2 mt-0"
            prepend="Организация"/>
        <MDBInputGroup
            material
            containerClassName="mb-2 mt-0"
            prepend="Фио ЛПР"/>    
        <MDBInputGroup
            material
            containerClassName="mb-2 mt-0"
            prepend="Телефон ЛПР"/>    
        <MDBInputGroup
            material
            containerClassName="mb-2 mt-0"
            prepend="Почта ЛПР"/>    
        <MDBInputGroup
            material
            containerClassName="mb-2 mt-0"
            prepend="Контакты"/>    
                <div style={{ display: "flex" }}>
        <MDBBtn outline color="success" style={{ marginLeft: "auto", float: "right" }}>Продолжить</MDBBtn>
        </div>
        <MDBInput type="textarea" label="Комментарий оператора" rows="5" />
      </MDBContainer>
    );
  }
}
export default FormComponent;
