import React from 'react'
import { Link } from 'react-router-dom'
import { connect } from 'react-redux'
import { ThunkDispatch } from 'redux-thunk'
import { bindActionCreators } from 'redux'

import { AppState } from '../store'
import { AppActions } from '../models/actions'
import { getContacts, makeCalls, receiveCalls, sendMails as sendMail } from '../actions'
import { Contact } from '../models'

import * as core from '@material-ui/core'

import InfoTextBlock from './InfoComponent'
import SearchComponent from './SearchComponent'
import RadioBtnComponent from './RadioBtnComponent'
import NoticeModal from './NoticeComponent'

import user_type  from './CheckRoleUser'

interface State {
  id: number
  naimenovanie: string
  fio: string
  nomer: string
  email: string
  comment: string
  submitted: boolean
  additional_info_block: HTMLElement[]
  st_operator: boolean
  notice: boolean
  err: boolean
  err_text: string
  status_call: string
  request_call: string
  needMailSend: boolean
  date : string
  date_recall : string
  border : React.CSSProperties['border']
}

type Props = LinkStateProps & LinkDispatchProps
export class FormComponent extends React.Component<Props, State> {
  constructor( props: Props ) {
    super( props )
    this.state = {
      id: 0,
      naimenovanie: '',
      fio: '',
      nomer: '',
      email: '',
      comment: '',
      submitted: false,
      additional_info_block: [],
      st_operator: false,
      notice: false,
      err: false,
      err_text : '',
      status_call: '',
      request_call: '',
      needMailSend: false,
      //new Date(new Date().toString().split('GMT')[0]+' UTC').toISOString().split('.')[0],
      date : '',
      date_recall : '',
      border : ''
    }
    this.textAreaHandleChange = this.textAreaHandleChange.bind( this )
    this.inputHandleChange = this.inputHandleChange.bind( this )
    this.selectHandleChange = this.selectHandleChange.bind( this )
    this.callHandler = this.callHandler.bind( this )
  }

  textAreaHandleChange( e ) {
    this.setState({ comment: e.target.value })
  }

  inputHandleChange( e: React.ChangeEvent<HTMLInputElement> ) {
    const { name, value } = e.target
    switch ( name ) {
      case 'company_name':
        this.setState({ naimenovanie: value })
        break
      case 'fio_lpr':
        this.setState({ fio: value })
        break
      case 'company_phone':
        this.setState({ nomer: value })
        break
      case 'company_mail':
        this.setState({ email: value })
        break
      case 'date_recall':
        this.setState({ date_recall: value })
        break
      
    }
  }

  selectHandleChange( event: React.ChangeEvent<HTMLSelectElement> ) {
    const { name, value } = event.target
    switch ( name ) {
      case 'status_call':
        this.setState({ status_call: value })
        break
      case 'request_call':
        this.setState({ request_call: value })
        break
    }
  }

  callHandler( event ) {
    event.preventDefault()
    //TODO: заменить на .env OUTGOING/INCOMING/APC
    let project_type: string = 'INCOMING'
    if (project_type == 'INCOMING') {
      //this.props.receive_calls()
    }
    // Проверка на заполнение обязательных полей
    this.setState({ submitted: true })
    if ( !this.state.status_call || !this.state.request_call ) {
      this.setState({ err : true })
      this.setState({ err_text : 'Не все обязательные поля заполненны!' })
      this.setState({ border : '2px solid red' })
      return
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
      naimenovanie: this.state.naimenovanie
    }
    if ( this.state.needMailSend ) {
      const url : string = 'mail'
      const method : string ='POST'
      sendMail( url, method, data )
    }
  }
  needMailSend = () => {
    this.setState({ needMailSend: !this.state.needMailSend })
  }

  componentDidMount() {
    this.props.get_contacts()
    console.log( user_type )
  }
  
  componentWillReceiveProps( nextProps ) {

    this.setState({
        id: nextProps.contacts.Contact[0].id || '',
        naimenovanie: nextProps.contacts.Contact[0].naimenovanie || '',
        fio: nextProps.contacts.Contact[0].fio || '',
        nomer: nextProps.contacts.Contact[0].nomer || '',
        email: nextProps.contacts.Contact[0].email || '',
        st_operator: true,
        notice: true,
        request_call: '',
        status_call: '',
        needMailSend: false,
        submitted: false,
        err: false,
        err_text: '',
        border : ''
      })
      this.noticeVisibleToggle()
      this.setAdditionalInfoBlock( nextProps.contacts.Contact[0] )
    
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
    for (var key in contact ) {
      var el_main_form = key_contact.indexOf( key )
      if ( el_main_form == -1 && contact[key] ) {
        html_element.push(
          <div id = { key } style = {{ fontSize: 18 }} key = { key }>
            { key }: { contact[key] }
          </div>
        )
      }
    }
    this.setState({ additional_info_block: html_element })
  }

  render() {
    return (
      <core.Container component='main'>
        <div style = {{ fontSize: 30, textAlign: 'center' }}>
          'Название проекта'
        </div>
        <core.Grid container spacing = { 3 } style = {{ marginTop: 5 }}>
          <core.Hidden only = { ['sm', 'xs'] }>
            <core.Grid item xs style = {{ border: '2px solid' }} md = { 3 }>
                { user_type !== 'Operator' && (
                  <div
                  style = {{
                    fontSize: 20,
                    border: '2px solid black',
                    width: '100%',
                    background: '#2196f3',
                    textAlign: 'center',
                    height: 56,
                    lineHeight: '56px',
                  }}
                >
                  <Link to = '/dashboard'>Панель управления</Link>
                  </div>
                )}
                <div
                  className = 'additional_info'
                  style = {{
                    background: 'darkseagreen',
                    lineHeight: '22px',
                    marginTop: '15px',
                    borderRadius: '4px',
                    padding: '15px',
                    textAlign: 'left',
                  }}
                >
                  { this.state.additional_info_block.map(( element, key ) => (
                    <div key = { key }>{ element }</div>
                  ))}
                
              </div>
            </core.Grid>
          </core.Hidden>
          <core.Grid item lg = { 6 } md = { 9 } sm = { 12 }>
            <form className = 'form' onSubmit = { this.callHandler }>
              <InfoTextBlock 
              />
              <core.TextField
                variant = 'outlined'
                margin = 'normal'
                required={true}
                fullWidth
                id = 'name'
                label = 'Наименование организации'
                name = 'company_name'
                value = { this.state.naimenovanie }
                onChange = { this.inputHandleChange }
              />
              <core.TextField
                variant = 'outlined'
                margin = 'normal'
                required = { true }
                fullWidth
                id = 'fio_lpr'
                label = 'ФИО ЛПР'
                name = 'fio_lpr'
                value = { this.state.fio }
                onChange = { this.inputHandleChange }
              />
              <core.TextField
                variant = 'outlined'
                margin = 'normal'
                required = { true }
                fullWidth
                id = 'phone'
                label = 'телефон организации'
                name = 'company_phone'
                value = { this.state.nomer }
                onChange = { this.inputHandleChange }
              />
              <RadioBtnComponent />
              <core.TextField
                variant = 'outlined'
                margin = 'normal'
                required = { true }
                fullWidth
                id = 'mail'
                label = 'почта организации'
                name = 'company_mail'
                value = { this.state.email }
                onChange = { this.inputHandleChange }
              />
              <core.InputLabel id = 'request_call-label'>Статус обращения</core.InputLabel>
              <core.NativeSelect
                style = {{ width: '215px', border : this.state.border }}
                id = 'request_call'
                name = 'request_call'
                onChange = { this.selectHandleChange }
                value = { this.state.request_call }
              >
                <option value = '' />
                <option value = { 'Суть обращения' }>Суть обращения</option>
                <option value = { 'Статус обращения' }>Статус обращения</option>
                <option value = { 'Результат обращения' }>Результат обращения</option>
              </core.NativeSelect>
              <core.InputLabel id = 'status_call-label' >Статус звонка</core.InputLabel>
              <core.NativeSelect
                style = {{ width: '215px', border : this.state.border }}
                id = 'status_call'
                name = 'status_call'
                onChange = { this.selectHandleChange }
                value = { this.state.status_call }
              >
                <option value = '' />
                <option value = { 'Перезвон1' }>Перезвон1</option>
                <option value = { 'Перезвон2' }>Перезвон2</option>
                <option value = { 'Перезвон3' }>Перезвон3</option>
                <option value = { 'Недозвон' }>Недозвон</option>
              </core.NativeSelect>
              <br/>
              <core.TextField
                id = 'datetime-local'
                label = 'Выбрать дату'
                type = 'datetime-local'
                name = 'date_recall'
                defaultValue = { this.state.date }
                onChange = { this.inputHandleChange }
                InputLabelProps = {{
                  shrink: true,
                }}
              />
              <br />
              <core.FormControlLabel
                className = 'custom-control-input'
                id = 'customSwitches'
                checked = { this.state.needMailSend }
                onChange = { this.needMailSend }
                value = 'end'
                control = { <core.Checkbox color = 'primary' /> }
                label = 'Отправить коммерческое предложение'
                labelPlacement = 'end'
              />
              <core.TextareaAutosize
                aria-label = 'minimum height'
                rowsMin = { 3 }
                placeholder = 'Комментарий оператора'
                style = {{ width: '100%' }}
                id = 'operator_comment'
                name = 'operator_comment'
                value = { this.state.comment }
                onChange = { this.textAreaHandleChange }
              />
              <core.Button
                type = 'submit'
                variant = 'contained'
                color = 'primary'
                className = 'submit'
              >
                Продолжить
              </core.Button>
            </form>
            { 
              this.state.notice ? <NoticeModal /> : null 
            }
            { 
              this.state.submitted && this.state.err && (
              <NoticeModal err = { this.state.err } err_text = { this.state.err_text } />
            )}
          </core.Grid>
          <core.Hidden only = { ['md', 'sm', 'xs'] }>
            <core.Grid item xs style = {{ border: '2px solid' }}>
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

const mapStateToProps = ( state: AppState ) => ({
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
