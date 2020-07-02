import * as React from "react"
import Container from "@material-ui/core/Container"
import { Button, TextField, CssBaseline, 
  FormControlLabel, Checkbox 
} from "@material-ui/core"
import Alert from "@material-ui/lab/Alert"
import { ajaxAction } from '../services'

interface Props {
  history: any
  location: any
}
interface State {
  username: string;
  password: string;
  submitted: boolean;
  failure: boolean;
  token : string
}
class LoginComponent extends React.Component<Props, State> {

  constructor( props: Props ) {
    super( props )
    this.state = {
      username: "",
      password: "",
      submitted: false,
      failure: false,
      token : ''
    }
  }
  
  handleChange( e: React.ChangeEvent<HTMLInputElement> ) {
    const { name, value } = e.target;
    switch (name) {
      case "username":
        this.setState({ username: value })
        break;
      case "password":
        this.setState({ password: value })
        break;
    }
  }

  //TODO: tokenExpiry
  async login( url: string, method: string, data : any ){
      let resp: any
      resp  = await ajaxAction( url, method, data )
      return resp
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
    };
    const url = 'login'
    const method = 'POST'
    let resp : any
    resp = await this.login( url, method, data )
    const { user_token , token_exp, user_group } = resp
    if( user_token ){
      localStorage.setItem( 'token', user_token )
      localStorage.setItem( 'token_exp', token_exp )
      localStorage.setItem( 'user_group', user_group )
    }

    if(localStorage.getItem('token')){
      const { history } = this.props
        history.push("/main")  
        window.location.reload()
      }
  }

  render() {

    return (
      <Container component="main" maxWidth="xs">
        <CssBaseline />
        <div>
          {this.state.failure && (
            <Alert variant="outlined" severity="error">
              Введены некорректные данные для авторизации
            </Alert>
          )}
          <form
            noValidate
            onSubmit={this.handleSubmit.bind(this)}
          >
            <TextField
              variant="outlined"
              margin="normal"
              required
              fullWidth
              id="username"
              label="Логин оператора"
              name="username"
              value={this.state.username}
              onChange={this.handleChange.bind(this)}
            />
            {this.state.submitted && !this.state.username && (
              <div>Требуется логин оператора</div>
            )}
            <TextField
              variant="outlined"
              margin="normal"
              required
              fullWidth
              name="password"
              label="Пароль оператора"
              type="password"
              id="password"
              value={this.state.password}
              onChange={this.handleChange.bind(this)}
            />
            {this.state.submitted && !this.state.password && (
              <div>Требуется пароль</div>
            )}
            <FormControlLabel
              control={<Checkbox value="remember" color="primary" />}
              label="Запомнить меня"
              name="persistent"
              value={true}
            />
            <Button type="submit" fullWidth variant="contained" color="primary">
              Вход
            </Button>
          </form>
        </div>
      </Container>
    )
  }
}
export default LoginComponent
