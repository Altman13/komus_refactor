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
import { keys } from "@material-ui/core/styles/createBreakpoints";
import { constants } from "buffer";
// interface Props {
//   classes: any;
//   //openSession: typeof openSession
//   // history: any
//   // location: any
//   //session: session
// }

interface State {
  //endpoint: string
  // username: string;
  // password: string;
  // submitted: boolean;
  // failure: boolean;
  // persistent: boolean;
  // adress: string;
  temp: any;
  loading: boolean;
}
interface Block {
  _uid: string;
  component: string;
  headline: string;
}
type Props = LinkStateProps & LinkDispatchProps;
export class FormComponent extends React.Component<Props, State> {
  _isMounted = false;
  constructor(props: Props) {
    super(props);
  }
  // handleChange(e: React.ChangeEvent<HTMLInputElement>) {
  //   const { name, value } = e.target;
  //   switch (name) {
  //     // case "endpoint":
  //     //     this.setState({ endpoint: value })
  //     //     break
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
    //console.log(this.test)
    // const response = fetch("http://localhost/komus_new/api/calls")
    //   .then((response) => response.json())
    //   .then((data) => {
    //  this.test = data[0]["inn"]
    // this.setState({temp : data[0]["inn"]})
    //   })
    //   console.log(this.test)
    //console.log(this.state.temp)
    // this._isMounted = true;
    // if (this._isMounted) {
    //   const ff=this.getcall()
    //   console.log(ff)
    //console.log(this.state.temp)
    //}

    //this.getcall()
    // const response = fetch("http://localhost/komus_new/api/calls")
    //   .then((response) => response.json())
    //   .then((data) => {
    //     //this.inn = data.inn
    //   //this.setState({inn : data.inn})
    //   })
    //console.log(this.inn)
    // fetch("http://localhost/komus_new/api/calls")
    //   .then((response) => response.json())
    //   .then((json) => {
    //     //console.log(json)
    //     this.setState({data : json})
    //   })
    //console.log(this.state)
    // const cont =this.getcall()
    //console.log(this.state.data)
    // this.setState({data : cont})
    //fetch("http://localhost/komus_new/api/calls")
    // await fetch("https://jsonplaceholder.typicode.com/todos/1")
    //   .then((response) => response.json())
    //   .then((json) => {
    //     //  const response = await fetch("http://localhost/komus_new/api/calls")
    //     //  const json = await response.json();
    //     //  this.setState({data : json})
    //     // .then((response) => response.json())
    //     // .then((json) => {
    //     //if (this._is_mounted) {
    //     this.setState({ data: json, loading: true });
    //     // this.adress = json.adres;
    //     //}
    //   });
    this.rec_call();
  }

  rec_call = (): void => {
    this.props.receiveCall();
  };
  render() {
    const { contacts } = this.props;
      contacts.map(cont=>{
        console.log(Object.keys(cont))
        console.log(Object.values(cont))
      })
    // contacts.forEach((element) => {
    //   for (let index = 0; index < 10; index++) {
    //     console.log(element[index].name);
    //   }
    // });

    //{data.content.body.map(block => console.log(block.component))}

    // contacts[0].map(function(v: Contact, i: number){
    //   console.log(v.name+ ' ' + i)
    // })
    // for (var prop in contacts[0]) {
    //     console.log(prop)
    //   }
    //const template = Object.keys(contacts[0]).map(item => <span key={item.id}>{item.email}</span>)
    // contacts[0].map(function(v: any, i: number){
    //     console.log(v.name+ ' ' + i)
    //   })
    //const { classes } = this.props;
    // const _is_mounted = this._is_mounted;
    // if(this._is_mounted)
    return (
      <Container component="main" maxWidth="sm">
        <CssBaseline />
        <div>
          {/* {this.state.failure && (
            <React.Fragment>
              <div className={classes.failure}>Неудачный вход</div>
              <div className={classes.failure}>Некорректные логин/пароль</div>
            </React.Fragment>
          )} */}
          <form
            className="form"
            noValidate
            // onSubmit={this.handleSubmit.bind(this)}
          >
            <InfoTextBlock />
            
            {contacts.map((contact) => (
                <p id={`${Object.keys(contact)}`}>{Object.values(contact)}</p>
            ))}
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
              className="submit"
            >
              Продолжить
            </Button>
          </form>
          <input type="button" value="test" onClick={() => this.rec_call()} />
        </div>
      </Container>
    );
  }
}
interface LinkStateProps {
  contacts: Contact[];
}
interface LinkDispatchProps {
  //makeCall: (contacts: Contact ) => void;
  receiveCall: () => void;
}
const mapStateToProps = (
  state: AppState
  //ownProps: HomePageProps
): LinkStateProps => ({
  contacts: state.contacts,
});

const mapDispatchToProps = (
  dispatch: ThunkDispatch<any, any, AppActions>
  //ownProps: HomePageProps
): LinkDispatchProps => ({
  receiveCall: bindActionCreators(rec_call, dispatch),
});

export default connect(mapStateToProps, mapDispatchToProps)(FormComponent);

//export default FormComponent;
