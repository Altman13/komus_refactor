import * as React from "react"
import Container from "@material-ui/core/Container"
import { Button, TextField, CssBaseline, 
  FormControlLabel, Checkbox 
} from "@material-ui/core"
import Alert from "@material-ui/lab/Alert"
import { ajaxAction } from '../services';

interface Props {
  //classes: any;
  //openSession: typeof openSession
  history: any
  location: any
  //session: session
}

interface State {
  username: string;
  password: string;
  submitted: boolean;
  failure: boolean;
}

class LoginComponent extends React.Component<Props, State> {

  constructor(props: Props) {
    super(props);
    this.state = {
      username: "",
      password: "",
      submitted: false,
      failure: false,
    };
  }
  
  handleChange(e: React.ChangeEvent<HTMLInputElement>) {
    const { name, value } = e.target;
    switch (name) {
      case "username":
        this.setState({ username: value });
        break;
      case "password":
        this.setState({ password: value });
        break;
    }
  }

  //TODO: tokenExpiry
  async login(url: string, method: string, data : any){
      
      let resp: any
      resp  = await ajaxAction( url, method, data )
      localStorage.setItem( 'token', resp.user_token )
      localStorage.setItem( 'token_exp', resp.token_exp )
      localStorage.setItem( 'user_group', resp.user_group )
      // console.log( 'localStrorage :>> ', localStorage )
      //this.setState({ failure: true })
  }
  handleSubmit(e: React.FormEvent<HTMLFormElement>) {
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
    this.login(url, method, data)
    this.props.history.push('/');
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
export default LoginComponent;
