import React from "react"
import { Link } from "react-router-dom"
import { connect } from "react-redux"
import { ThunkDispatch } from "redux-thunk"
import { bindActionCreators } from "redux"

import { AppState } from "../store"
import { AppActions } from "../models/actions"
import { getContacts, makeCalls, receiveCalls, sendMails } from "../actions"
import { Contact } from "../models"

import * as core from "@material-ui/core"

import InfoTextBlock from "./InfoComponent"
import SearchComponent from "./SearchComponent"
import RadioBtnComponent from "./RadioBtnComponent"
import NoticeModal from "../components/NoticeComponent"

interface State {
  id: number
  naimenovanie: string
  fio: string
  nomer: string
  email: string
  comment: string
  //submitted: boolean
  additional_info_block: HTMLElement[]
  st_operator: boolean
  notice: boolean
  err: boolean
  status_call: string
  request_call: string
  send_mail_kp: boolean
  date : string
  date_recall : string
}

type Props = LinkStateProps & LinkDispatchProps;
export class FormComponent extends React.Component<Props, State> {
  constructor( props: Props ) {
    super( props )
    this.state = {
      id: 0,
      naimenovanie: "",
      fio: "",
      nomer: "",
      email: "",
      comment: "",
      //submitted: false,
      additional_info_block: [],
      st_operator: false,
      notice: false,
      err: false,
      status_call: "",
      request_call: "",
      send_mail_kp: false,
      //new Date(new Date().toString().split('GMT')[0]+' UTC').toISOString().split('.')[0],
      date : "",
      date_recall : ""
    };
    this.inputHandleChange = this.inputHandleChange.bind( this )
    this.makeCallHandler = this.makeCallHandler.bind( this )
    this.selectHandleChange = this.selectHandleChange.bind( this )
  }

  onChange( e ) {
    this.setState({ comment: e.target.value })
  }

  inputHandleChange( e: React.ChangeEvent<HTMLInputElement> ) {
    const { name, value } = e.target
    switch ( name ) {
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
      case "date_recall":
        this.setState({ date_recall: value })
        break
      
    }
  }

  makeCallHandler( event ) {
    event.preventDefault()
    //TODO: заменить на .env OUTGOING/INCOMING/APC
    let project_type: string = "INCOMING"
    if (project_type == "INCOMING") {
      //this.props.receive_calls()
    }
    const call = {
      status_call : this.state.status_call,
      requst_call : this.state.request_call,
      id : this.state.id
    }
    this.props.make_calls( call )
    const data = {
      id : this.state.id,
      mail : this.state.email,
    }
    if ( this.state.send_mail_kp ) {
      sendMails( 'mail', 'POST', data )
    }
  }

  componentDidMount() {
    this.props.get_contacts()
  }
  
  componentWillReceiveProps( nextProps ) {
    var contact
    Object.keys( nextProps.contacts ).forEach( function eachKey( key ) {
      contact = nextProps.contacts[key]
    })

    if ( contact ) {
      this.setState({
        id: contact.id,
        naimenovanie: contact.naimenovanie,
        fio: contact.fio,
        nomer: contact.nomer,
        email: contact.email,
        st_operator: true,
        notice: true,
        request_call: "",
        status_call: "",
        send_mail_kp: false,
      })
      this.noticeVisibleToggle()
      this.setAdditionalInfoBlock( contact )
    }
  }

  noticeVisibleToggle() {
    setTimeout(() => {
      this.setState({ notice: false })
    }, 6000 )
  }

  //если элемента нет на главной форме отображаем в дополнительном блоке
  setAdditionalInfoBlock( contact: any ) {
    var key_contact = Object.keys( this.state )
    var html_element: any = []
    for (let [key, value] of Object.entries( contact )) {
      var el_main_form = key_contact.indexOf( key )
      if ( el_main_form == -1 && value ) {
        html_element.push(
          <div id = { key } style = {{ fontSize: 18 }} key = { key }>
            { key }: { value }
          </div>
        )
      }
    }
    this.setState({ additional_info_block: html_element })
  }

  selectHandleChange( event: React.ChangeEvent<HTMLSelectElement> ) {
    const { name, value } = event.target
    switch ( name ) {
      case "status_call":
        this.setState({ status_call: value })
        break
      case "request_call":
        this.setState({ request_call: value })
        break
    }
  }

  sendMailKp = () => {
    this.setState({ send_mail_kp: !this.state.send_mail_kp })
  }

  render() {
    return (
      <core.Container component="main">
        <div style = {{ fontSize: 30, textAlign: "center" }}>
          "Название проекта"
        </div>
        <core.Grid container spacing = { 3 } style = {{ marginTop: 5 }}>
          <core.Hidden only = { ["sm", "xs"] }>
            <core.Grid item xs style = {{ border: "2px solid" }} md = { 3 }>
              <div
                style={{
                  fontSize: 20,
                  border: "2px solid black",
                  width: "100%",
                  background: "#2196f3",
                  textAlign: "center",
                  height: 56,
                  lineHeight: "56px",
                }}
              >
                { this.state.st_operator === true && (
                  <Link to = "/dashboard">Панель управления</Link>
                )}
                <div
                  className = "additional_info"
                  style={{
                    background: "darkseagreen",
                    lineHeight: "22px",
                    marginTop: "15px",
                    borderRadius: "4px",
                    padding: "15px",
                    textAlign: "left",
                  }}
                >
                  { this.state.additional_info_block.map(( element, key ) => (
                    <div key = { key }>{ element }</div>
                  ))}
                </div>
              </div>
            </core.Grid>
          </core.Hidden>
          <core.Grid item lg = { 6 } md = { 9 } sm = { 12 }>
            <form className = "form" noValidate>
              <InfoTextBlock />
              <core.TextField
                variant = "outlined"
                margin = "normal"
                required
                fullWidth
                id = "name"
                label = "Наименование организации"
                name = "company_name"
                value = { this.state.naimenovanie }
                onChange = { this.inputHandleChange }
              />
              <core.TextField
                variant = "outlined"
                margin = "normal"
                required
                fullWidth
                id = "fio_lpr"
                label = "ФИО ЛПР"
                name = "fio_lpr"
                value = { this.state.fio }
                onChange = { this.inputHandleChange }
              />
              <core.TextField
                variant = "outlined"
                margin = "normal"
                required
                fullWidth
                id = "phone"
                label = "телефон организации"
                name = "company_phone"
                value = { this.state.nomer }
                onChange = { this.inputHandleChange }
              />
              <RadioBtnComponent />
              <core.TextField
                variant = "outlined"
                margin = "normal"
                required
                fullWidth
                id = "mail"
                label = "почта организации"
                name = "company_mail"
                value = { this.state.email || "" }
                onChange = { this.inputHandleChange }
              />
              <core.InputLabel id = "request_call-label">Статус обращения</core.InputLabel>
              <core.NativeSelect
                style = {{ width: "215px" }}
                id = "request_call"
                name = "request_call"
                onChange = { this.selectHandleChange }
                value = { this.state.request_call }
              >
                <option value = "" />
                <option value = { "Суть обращения" }>Суть обращения</option>
                <option value = { "Статус обращения" }>Статус обращения</option>
                <option value = { "Результат обращения" }>Результат обращения</option>
              </core.NativeSelect>
              <core.InputLabel id="status_call-label">Статус звонка</core.InputLabel>
              <core.NativeSelect
                style = {{ width: "215px" }}
                id = "status_call"
                name = "status_call"
                onChange = { this.selectHandleChange }
                value = { this.state.status_call }
              >
                <option value = "" />
                <option value = { "Перезвон1" }>Перезвон1</option>
                <option value = { "Перезвон2" }>Перезвон2</option>
                <option value = { "Перезвон3" }>Перезвон3</option>
                <option value = { "Недозвон" }>Недозвон</option>
              </core.NativeSelect>
              <br/>
              
              <core.TextField
                id = "datetime-local"
                label = "Выбрать дату"
                type = "datetime-local"
                name = "date_recall"
                defaultValue = { this.state.date }
                onChange = { this.inputHandleChange }
                InputLabelProps = {{
                  shrink: true,
                }}
              />
              <br />

              <core.FormControlLabel
                className = "custom-control-input"
                id = "customSwitches"
                checked = { this.state.send_mail_kp }
                onChange = { this.sendMailKp }
                value = "end"
                control = { <core.Checkbox color="primary" /> }
                label = "Отправить коммерческое предложение"
                labelPlacement = "end"
              />
              <core.TextareaAutosize
                aria-label = "minimum height"
                rowsMin = { 3 }
                placeholder = "Комментарий оператора"
                style = {{ width: "100%" }}
                id = "operator_comment"
                name = "operator_comment"
                value = { this.state.comment }
                onChange = { this.onChange.bind(this) }
              />
              <core.Button
                type = "submit"
                variant = "contained"
                color = "primary"
                className = "submit"
                onClick = { this.makeCallHandler }
              >
                Продолжить
              </core.Button>
            </form>
            { this.state.notice ? <NoticeModal err = { this.state.err } /> : null }
          </core.Grid>
          <core.Hidden only = { ["md", "sm", "xs"] }>
            <core.Grid item xs style = {{ border: "2px solid" }}>
              <SearchComponent />
              <InfoTextBlock />
            </core.Grid>
          </core.Hidden>
        </core.Grid>
      </core.Container>
    )
  }
}
interface LinkStateProps {
  contacts: Contact
}
interface LinkDispatchProps {
  get_contacts: () => void
  make_calls: ( data : any ) => void
  receive_calls: () => void
}
const mapStateToProps = ( state: AppState ): LinkStateProps => ({
  contacts: state.contacts,
})

const mapDispatchToProps = (
  dispatch: ThunkDispatch<any, any, AppActions>
): LinkDispatchProps => ({
  get_contacts: bindActionCreators( getContacts, dispatch ),
  make_calls: bindActionCreators( makeCalls, dispatch ),
  receive_calls: bindActionCreators( receiveCalls, dispatch ),
})

export default connect( mapStateToProps, mapDispatchToProps )( FormComponent )
