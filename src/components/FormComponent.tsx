import React from "react"
import MailSendComponent from "./MailSendComponent"
import TextareaAutosize from "@material-ui/core/TextareaAutosize"
import CustomizedSelects from "./SelectComponent"
import { Button, TextField } from "@material-ui/core"
import CssBaseline from "@material-ui/core/CssBaseline"
import Container from "@material-ui/core/Container"
import InfoTextBlock from "./InfoComponent"
import { connect } from "react-redux"
import { AppState } from "../store"
import { bindActionCreators } from "redux"
import { AppActions } from "../models/actions"
import { ThunkDispatch } from "redux-thunk"
import { Contact } from "../models"
import { get_contacts,  make_calls } from "../actions/"
import SearchComponent from "./SearchComponent"
import RadioBtnComponent from "./RadioBtnComponent"

import Box from "@material-ui/core/Box"

interface State {
  naimenovanie: string
  fio: string
  nomer: string
  email: string
  comment: string
  submitted: boolean
  html_cont : any[]
}

type Props = LinkStateProps & LinkDispatchProps;
export class FormComponent extends React.Component<Props, State> {

  constructor(props: Props) {
    super(props)
    this.state = { naimenovanie: "", fio: "", nomer: "", email: "", comment: "", submitted: false, html_cont: []}
    this.handleChange = this.handleChange.bind(this)
  }
  onChange(e) {
    this.setState({comment: e.target.value})
    this.props.make_calls(this.props.contacts.id)
  }

  handleChange(e: React.ChangeEvent<HTMLInputElement>) {
    const { name, value } = e.target
    switch (name) {
      case "company_name":
        this.setState({ naimenovanie: value })
        break
      case "fio_lpr":
        this.setState({ fio: value })
        break
      case "company_phone":
        this.setState({ nomer: value })
        break
      case "company_mail":
        this.setState({ email: value })
        break
    }
  }
  handleSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault()

    // this.props.makeCall()
    // this.setState({ submitted: true });
  }

  componentDidMount() {
    this.props.get_contacts()
  }

  componentWillReceiveProps(nextProps) {
    
    var contact
    Object.keys(nextProps.contacts).forEach(function eachKey(key) {
      contact = nextProps.contacts[key]
    })

    this.setState({
      naimenovanie: contact.naimenovanie,
      fio: contact.fio,
      nomer: contact.nomer,
      email: contact.email,
    })
      
      var key_contact= Object.keys(this.state)
      
      for (let [key, value] of Object.entries(contact)) {
        var el_main_form =key_contact.indexOf(key)
        if(el_main_form==-1)
        {
          this.state.html_cont.push(<div id={key} style={{ fontSize: 18 }} key={key}>
              {key}: {value}
            </div>
          );
        }
      }
  }

  render() {

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
            {this.state.html_cont}
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
                value={this.state.naimenovanie}
                onChange={this.handleChange}
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
                onChange={this.handleChange}
              />
              <TextField
                variant="outlined"
                margin="normal"
                required
                fullWidth
                id="phone"
                label="телефон организации"
                name="company_phone"
                value={this.state.nomer}
                onChange={this.handleChange}
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
                onChange={this.handleChange}
              />
              <CustomizedSelects />
              <MailSendComponent />
              <TextareaAutosize
                aria-label="minimum height"
                rowsMin={3}
                placeholder="Комментарий оператора"
                style={{ width: "100%" }}
                id="operator_comment"
                name="operator_comment"
                value={this.state.comment}
                onChange={this.onChange.bind(this)}
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
  contacts: Contact
}
interface LinkDispatchProps {
  //makeCall: (contacts: Contact ) => void;
  get_contacts: () => void,
  make_calls: (id: number) => void
}
const mapStateToProps = (state: AppState): LinkStateProps => ({
  contacts: state.contacts,
});

const mapDispatchToProps = (
  dispatch: ThunkDispatch<any, any, AppActions>,
): LinkDispatchProps => ({
  get_contacts: bindActionCreators(get_contacts, dispatch),
  make_calls : bindActionCreators(make_calls, dispatch)
})

export default connect(mapStateToProps, mapDispatchToProps)(FormComponent);
