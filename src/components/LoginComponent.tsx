import * as React from "react"
import Container from "@material-ui/core/Container"
import { Button, TextField, CssBaseline, 
  FormControlLabel, Checkbox 
} from "@material-ui/core"
import Alert from "@material-ui/lab/Alert"
import { Redirect} from "react-router-dom";
interface Props {
  //classes: any;
  //openSession: typeof openSession
  // history: any
  // location: any
  //session: session
}

interface State {
  username: string;
  password: string;
  submitted: boolean;
  failure: boolean;
  token : string
}

class LoginComponent extends React.Component<Props, State> {
  state: State;

  constructor(props: Props) {
    super(props);
    this.state = {
      token : "",
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

  handleSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault()
    this.setState({ submitted: true })
    if (!this.state.username || !this.state.password) {
      return
    }
    const data = {
      username: this.state.username,
      userpassword: this.state.password,
    };
    const url = "http://localhost/komus_new/api/login"

    async function login(url = "", data = {}) {
      // Default options are marked with *
      const response = await fetch(url, {
        method: "POST", // *GET, POST, PUT, DELETE, etc.
        mode: "cors", // no-cors, *cors, same-origin
        cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
        credentials: "same-origin", // include, *same-origin, omit
        headers: {
          "Content-Type": "application/json",
          // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: "follow", // manual, *follow, error
        referrerPolicy: "no-referrer", // no-referrer, *client
        body: JSON.stringify(data), // body data type must match "Content-Type" header
      });
      return await response.json(); // parses JSON response into native JavaScript objects
    }
    login( url, data )
      .then(( data ) => {
        console.log( data )
        //TODO: tokenExpiry
        localStorage.setItem('token', data.user_token)
        localStorage.setItem('token_exp', data.token_exp)
        localStorage.setItem('user_group', data.user_group)
        console.log('localStrorage :>> ', localStorage);
            //return <Redirect to ='/'/>
    return <Redirect to="/"/>
      })
      .catch(() => {
        this.setState({ failure: true })
      })
  }
  componentWillUpdate(nextProps, nextState) {
    //return <Redirect to ='/'/>
    return <Redirect to="/"/>
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
