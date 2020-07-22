import * as React from 'react'
import * as core from '@material-ui/core'
import Alert from '@material-ui/lab/Alert'
import { ajaxAction } from '../services'

interface Props {
  history: any
  location: any
}
interface State {
  username: string
  password: string
  submitted: boolean
  failure: boolean
  token : string
}
class LoginComponent extends React.Component<Props, State> {

  constructor( props: Props ) {
    super( props )
    this.state = {
      username: '',
      password: '',
      submitted: false,
      failure: false,
      token : ''
    }
  }
  
  handleChange( e: React.ChangeEvent<HTMLInputElement> ) {
    const { name, value } = e.target
    switch ( name ) {
      case 'username':
        this.setState({ username: value })
        break
      case 'password':
        this.setState({ password: value })
        break
    }
  }
    
  async handleSubmit( e: React.FormEvent<HTMLFormElement> ) {
    e.preventDefault()
    this.setState({ submitted: true })
    if ( !this.state.username || !this.state.password ) {
      return
    }
    const data = {
      username: this.state.username,
      userpassword: this.state.password,
    }
    const url : string = 'login'
    const method : string = 'POST'
    const resp : any = await ajaxAction( url, method, data )
    if ( resp ) {
      const { data } = resp
      const { user_token , token_exp, user_group, user_fio } = data
      if( user_token ) {
        localStorage.setItem( 'token', user_token )
        localStorage.setItem( 'token_exp', token_exp )
        localStorage.setItem( 'user_group', user_group )
        localStorage.setItem( 'user_fio', user_fio )
        const { history } = this.props
        history.push('/main')  
        window.location.reload()
        }
      }
  }
//TODO: пофиксить ошибку при входе
componentWillMount () {
  if(localStorage.getItem ( 'token' )) {
  const { history } = this.props
  history.push('/main')  
  window.location.reload()
  }
}

  render() {

    return (
      <core.Container component = 'main' maxWidth = 'xs'>
        <core.CssBaseline />
        <div>
          {this.state.failure && (
            <Alert variant = 'outlined' severity = 'error'>
              Введены некорректные данные для авторизации
            </Alert>
          )}
          <form
            noValidate
            onSubmit = { this.handleSubmit.bind( this ) }
          >
            <core.TextField
              variant = 'outlined'
              margin = 'normal'
              required
              fullWidth
              id = 'username'
              label = 'Логин оператора'
              name = 'username'
              value = { this.state.username }
              onChange = { this.handleChange.bind( this ) }
            />
            {this.state.submitted && !this.state.username && (
              <div>Требуется логин оператора</div>
            )}
            <core.TextField
              variant = 'outlined'
              margin = 'normal'
              required
              fullWidth
              name = 'password'
              label = 'Пароль оператора'
              type = 'password'
              id = 'password'
              value = { this.state.password }
              onChange = { this.handleChange.bind( this ) }
            />
            {this.state.submitted && !this.state.password && (
              <div>Требуется пароль</div>
            )}
            <core.FormControlLabel
              control = { <core.Checkbox value='remember' color='primary' /> }
              label = 'Запомнить меня'
              name = 'persistent'
              value = { true }
            />
            <core.Button type = 'submit' fullWidth variant = 'contained' color = 'primary'>
              Вход
            </core.Button>
          </form>
        </div>
      </core.Container>
    )
  }
}
export default LoginComponent
