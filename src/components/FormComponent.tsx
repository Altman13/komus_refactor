import React from "react";
import MailSendComponent from "./MailSendComponent";
import TextareaAutosize from "@material-ui/core/TextareaAutosize";
import CustomizedSelects from "./SelectComponent";
import { Button, TextField } from "@material-ui/core";
//import Login from "./LoginComponent";
import CssBaseline from "@material-ui/core/CssBaseline";
import Container from "@material-ui/core/Container";
import InfoTextBlock from "./InfoComponent";
import { BasicExample } from "./t";
import { ResponsiveDrawer } from "./DashBoardComponent";
interface Props {
  classes: any;
  //openSession: typeof openSession
  // history: any
  // location: any
  //session: session
}
interface State {
  //endpoint: string
  username: string;
  password: string;
  submitted: boolean;
  failure: boolean;
  persistent: boolean;
}

export class FormComponent extends React.Component<Props, State> {
  constructor(props: Props) {
    super(props);
  }
  handleChange(e: React.ChangeEvent<HTMLInputElement>) {
    const { name, value } = e.target;
    switch (name) {
      // case "endpoint":
      //     this.setState({ endpoint: value })
      //     break
      case "username":
        this.setState({ username: value });
        break;
      case "password":
        this.setState({ password: value });
        break;
      case "persistent":
        this.setState({ persistent: Boolean(value) });
        break;
    }
  }
  handleSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    this.setState({ submitted: true });
    if (!this.state.username || !this.state.password) {
      return;
    }
  }

  componentDidMount() {
    fetch("http://localhost/react/php/komus_new/test.php")
      .then(response => response.json())
      .then(json => console.log(json));
  }
  render() {
    const { classes } = this.props;
    return (
      <Container component="main" maxWidth="md">
        <CssBaseline />
        <div className={classes.paper}>
          {/* {this.state.failure && (
            <React.Fragment>
              <div className={classes.failure}>Неудачный вход</div>
              <div className={classes.failure}>Некорректные логин/пароль</div>
            </React.Fragment>
          )} */}
          <form
            className={classes.form}
            noValidate
            onSubmit={this.handleSubmit.bind(this)}
          >
            <InfoTextBlock />
            <TextField
              variant="outlined"
              margin="normal"
              required
              fullWidth
              id="name"
              label="Наименование организации"
              name="company_name"
            />
            <TextField
              variant="outlined"
              margin="normal"
              required
              fullWidth
              id="fio_lpr"
              label="ФИО ЛПР"
              name="fio_lpr"
            />
            <TextField
              variant="outlined"
              margin="normal"
              required
              fullWidth
              id="phone"
              label="телефон организации"
              name="company_phone"
            />
            <TextField
              variant="outlined"
              margin="normal"
              required
              fullWidth
              id="phone"
              label="почта организации"
              name="company_mail"
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
              className={classes.submit}
            >
              Продолжить
            </Button>
          </form>
        </div>
        <BasicExample />
        <ResponsiveDrawer />
      </Container>
    );
  }
}

export default FormComponent;
