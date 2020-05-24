import React from "react"
import MailSendComponent from "./MailSendComponent"
import TextareaAutosize from "@material-ui/core/TextareaAutosize"
import CustomizedSelects from "./SelectComponent"
import { Button, TextField, Grid } from "@material-ui/core"
//import CssBaseline from "@material-ui/core/CssBaseline"
import Container from "@material-ui/core/Container"
import InfoTextBlock from "./InfoComponent"
import { connect } from "react-redux"
import { AppState } from "../store"
import { bindActionCreators } from "redux"
import { AppActions } from "../models/actions"
import { ThunkDispatch } from "redux-thunk"
import { Contact } from "../models"
import { get_contacts,  make_calls , receive_calls } from "../actions/"
import SearchComponent from "./SearchComponent"
import RadioBtnComponent from "./RadioBtnComponent"
import NativeSelect from "@material-ui/core/NativeSelect";
import InputLabel from '@material-ui/core/InputLabel';
import Box from "@material-ui/core/Box"
import { ResponsiveDrawer } from './DashBoardComponent';
import UploadFileComponent from './uploadTemp';
import Hidden from '@material-ui/core/Hidden';

interface State {
  id: number
  naimenovanie: string
  fio: string
  nomer: string
  email: string
  comment: string
  submitted: boolean
  html_cont : HTMLElement[]
  st_operator: boolean
}

type Props = LinkStateProps & LinkDispatchProps;
export class FormComponent extends React.Component<Props, State> {

  constructor(props: Props) {
    super(props)
    this.state = {id: 0, naimenovanie: "", fio: "", nomer: "", email: "", comment: "", submitted: false, html_cont: [], st_operator: false}
    this.handleChange = this.handleChange.bind(this)
    //this.handleSubmit = this.handleSubmit.bind(this)
    this.makeCallHandler = this.makeCallHandler.bind(this)
    
  }
  onChange(e) {
    this.setState({comment: e.target.value})
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

  // handleSubmit(e: React.FormEvent<HTMLFormElement>) {
  //   e.preventDefault()
  // this.props.makeCall()
  // this.setState({ submitted: true });
  // }

  makeCallHandler(event){
    event.preventDefault()
    //TODO: заменить на .env OUTGOING/INCOMING/APC
    let project_type:string = 'INCOMING'
    if(project_type=='INCOMING'){
      //this.props.receive_calls()
      }
      this.props.make_calls(this.state.id)
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
      id: contact.id,
      naimenovanie: contact.naimenovanie,
      fio: contact.fio,
      nomer: contact.nomer,
      email: contact.email,
      st_operator: true
    })
    
      var key_contact= Object.keys(this.state)
      var html_element:any=[]
      for (let [key, value] of Object.entries(contact)) {
        var el_main_form =key_contact.indexOf(key)
        if(el_main_form==-1 && value)
        { 
          html_element.push(<div id={key} style={{ fontSize: 18 }} key={key}>
              {key}: {value}
            </div>
          )
        }
      }
      this.setState({html_cont: html_element})
  }
  SelectHandleChange (event: React.ChangeEvent<{ value: unknown }>){
    console.log(event.target.value);
  }

  render() {
    
    return (
      <Container component="main">
        {
          this.state.st_operator === true &&
          <ResponsiveDrawer/>
        }
      <Grid container spacing={3}>
        <Hidden only="xs">
          <Grid item xs style={{ border: "2px solid" }}>
                  {this.state.html_cont.map((element, key) => <div key={key}>{element}</div>)}
          </Grid>
        </Hidden>
          <Grid item lg={6}>
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
                id="mail"
                label="почта организации"
                name="company_mail"
                value={this.state.email || ""}
                onChange={this.handleChange}
              />
              
              <InputLabel id="request_call-label">Статус обращения</InputLabel>
              <NativeSelect style={{ width: "200px" }}
                id="request_call"
                onChange={this.SelectHandleChange}
              >
                <option value="" />
                <option value={'Суть обращения'}>Суть обращения</option>
                <option value={'Статус обращения'}>Статус обращения</option>
                <option value={'Результат обращения'}>Результат обращения</option>
                
              </NativeSelect>
              <InputLabel id="status_call-label">Статус звонка</InputLabel>
              <NativeSelect style={{ width: "200px" }}
                id="status_call"
                onChange={this.SelectHandleChange}
              >
                <option value="" />
                <option value={'Перезвон1'}>Перезвон1</option>
                <option value={'Перезвон2'}>Перезвон2</option>
                <option value={'Перезвон3'}>Перезвон3</option>
                <option value={'Недозвон'}>Недозвон</option>
              </NativeSelect>
    
              {/* <CustomizedSelects onChange={this.handleChange} /> */}
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
                onClick={this.makeCallHandler}
              >
                Продолжить
              </Button>
            </form>
          </Grid>
          <Hidden only="xs">
            <Grid item xs style={{ border: "2px solid" }}>
              <SearchComponent />
              <InfoTextBlock />
            </Grid>
          </Hidden>
        </Grid>
      </Container>
    );
  }
}
interface LinkStateProps {
  contacts: Contact
}
interface LinkDispatchProps {
  get_contacts: () => void,
  make_calls: (id: number) => void,
  receive_calls: () =>void
}
const mapStateToProps = (state: AppState): LinkStateProps => ({
  contacts: state.contacts,
});

const mapDispatchToProps = (
  dispatch: ThunkDispatch<any, any, AppActions>,
): LinkDispatchProps => ({
  get_contacts: bindActionCreators(get_contacts, dispatch),
  make_calls : bindActionCreators(make_calls, dispatch),
  receive_calls : bindActionCreators(receive_calls, dispatch)
  
})

export default connect(mapStateToProps, mapDispatchToProps)(FormComponent);
