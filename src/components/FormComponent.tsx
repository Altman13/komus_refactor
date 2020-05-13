import React from "react";
import MailSendComponent from "./MailSendComponent";
import TextareaAutosize from "@material-ui/core/TextareaAutosize";
import CustomizedSelects from "./SelectComponent";
import { Button, TextField } from "@material-ui/core";
import CssBaseline from "@material-ui/core/CssBaseline";
import Container from "@material-ui/core/Container";
import InfoTextBlock from "./InfoComponent";
import { connect } from "react-redux";
import { AppState } from "../store";
import { bindActionCreators } from "redux";
import { AppActions } from "../models/actions";
import { ThunkDispatch } from "redux-thunk";
import { Contact } from "../models";
import { rec_call } from "../actions/";
import SearchComponent from "./SearchComponent";
import RadioBtnComponent from "./RadioBtnComponent";

import Box from "@material-ui/core/Box";

interface State {
  // temp: any;
  // loading: boolean;
  organization: string;
  fio: string;
  phone: string;
  email: string;
}

type Props = LinkStateProps & LinkDispatchProps;
export class FormComponent extends React.Component<Props, State> {
  _isMounted = false;
  constructor(props: Props) {
    super(props);
    this.state = { organization: "", fio: "", phone: "", email: "" };
    this.handleChange = this.handleChange.bind(this);
  }

  // handleChange(e: React.ChangeEvent<HTMLInputElement>) {
  //   const { name, value } = e.target;
  //   switch (name) {
  // case "endpoint":
  //     this.setState({ endpoint: value })
  //     break
  //     case "username":
  //       this.setState({ username: value });
  //       break;
  //     case "password":
  //       this.setState({ password: value });
  //       break;
  //     case "persistent":
  //       this.setState({ persistent: Boolean(value) });
  //       break;
  //   }
  // }
  // handleSubmit(e: React.FormEvent<HTMLFormElement>) {
  //   e.preventDefault();
  //   this.setState({ submitted: true });
  //   if (!this.state.username || !this.state.password) {
  //     return;
  //   }
  // }
  componentDidMount() {
    this.rec_call();

    //this.handleChange()
  }

  rec_call = (): void => {
    this.props.receiveCall();
  };
  componentWillReceiveProps(nextProps) {
    //console.log(this.props.contacts)
    console.log(nextProps.contacts);
    var obj;
    Object.keys(nextProps.contacts).forEach(function eachKey(key) {
      obj = nextProps.contacts[key];
      console.log(obj.naimenovanie);
    });

    this.setState({ organization: obj.naimenovanie, fio: obj.fio, phone: obj.nomer, email : obj.email });
  }
  handleChange() {}
  render() {
    const { contacts } = this.props;
    //console.log(typeof contacts)
    var obj;
    Object.keys(contacts).forEach(function eachKey(key) {
      obj = contacts[key];
      //console.log(obj.naimenovanie)
    });

    let html_element = new Array();
    if(contacts[146])
    for (let [key, value] of Object.entries(contacts[146])) {
          if (value)
          html_element.push(
            <div id={key} style={{ fontSize: 18 }}>
              {key}: {value}
            </div>
          );
      }
    //console.log(html_element[5])
    // //console.log(typeof obj);
    // let html_element = new Array();
    // if (obj)
    //   for (let [key, value] of Object.entries(obj)) {
    //     //console.log(`${key}: ${value}`);
    //     if (value)
    //       html_element.push(
    //         <div id={key} style={{ fontSize: 18 }}>
    //           {key}: {value}
    //         </div>
    //       );
    //   }
    return (
      <Container component="main">
        <Box
          display="flex"
          justifyContent="center"
          m={1}
          p={1}
          bgcolor="#c4e1a5"
        >
          <Box p={1} style={{ border: "2px solid" }} width="25%" boxShadow={3}>
            {html_element}
          </Box>
          <Box p={1} bgcolor="#c4e1a5" width="75%" boxShadow={1}>
            <form className="form" noValidate>
              <InfoTextBlock />
              <TextField
                variant="outlined"
                margin="normal"
                required
                fullWidth
                id="name"
                label="Наименование организации"
                name="company_name"
                value={this.state.organization}
              />
              <TextField
                variant="outlined"
                margin="normal"
                required
                fullWidth
                id="fio_lpr"
                label="ФИО ЛПР"
                name="fio_lpr"
                value={this.state.fio}
              />
              <TextField
                variant="outlined"
                margin="normal"
                required
                fullWidth
                id="phone"
                label="телефон организации"
                name="company_phone"
                value={this.state.phone}
              />
              <RadioBtnComponent />
              <TextField
                variant="outlined"
                margin="normal"
                required
                fullWidth
                id="phone"
                label="почта организации"
                name="company_mail"
                value={this.state.email || "Почты нет"}
              />
              <CustomizedSelects />
              <MailSendComponent />
              <TextareaAutosize
                aria-label="minimum height"
                rowsMin={3}
                placeholder="Комментарий оператора"
                style={{ width: "100%" }}
              />
              <Button
                type="submit"
                variant="contained"
                color="primary"
                className="submit"
              >
                Продолжить
              </Button>
            </form>
          </Box>
          <Box p={1} style={{ border: "2px solid" }} width="25%" boxShadow={3}>
            <SearchComponent />
            <InfoTextBlock />
          </Box>
        </Box>
      </Container>
    );
  }
}
interface LinkStateProps {
  contacts: Contact;
}
interface LinkDispatchProps {
  //makeCall: (contacts: Contact ) => void;
  receiveCall: () => void;
}
const mapStateToProps = (state: AppState): LinkStateProps => ({
  contacts: state.contacts,
});

const mapDispatchToProps = (
  dispatch: ThunkDispatch<any, any, AppActions>
): LinkDispatchProps => ({
  receiveCall: bindActionCreators(rec_call, dispatch),
});

export default connect(mapStateToProps, mapDispatchToProps)(FormComponent);
