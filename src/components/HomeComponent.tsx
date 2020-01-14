import React from "react";
import { connect } from "react-redux";
import { rec_call } from "../actions/";
import { Contact } from "../models";
import { AppState } from "../store"
import { Dispatch, bindActionCreators } from "redux";
import { AppActions } from "../models/actions";
import { ThunkDispatch } from "redux-thunk";

interface HomePageProps {
  id?: string;
  color?: string;
}

interface HomePageState {}
type Props = HomePageProps & LinkStateProps & LinkDispatchProps;

export class HomePagePage extends React.Component<Props, HomePageState> {
  // constructor(props: Props) {
  //   super(props);
  //   this.state = { contact : '' };
  // }
  rec_call = (contact: Contact) : void => {
    this.props.receiveCall(contact);
  };
  // MakeCall = (contact: Contact) : void => {
  //   this.props.makeCall(contact);
  // };
  render() {
    const { contacts } = this.props;
    return (
      <div>
        <h1>call Page</h1>
        <div>
          {contacts.map(contact => (
            <div>
              <p>{contact.id}</p>
              <p>{contact.fio_lpr}</p>
              <p>{contact.mail_lpr}</p>
                Remove contact
              <button onClick={() => this.rec_call(contact)}>Edit contact</button>
            </div>
          ))}
        </div>
      </div>
    );
  }
}

interface LinkStateProps {
  contacts: Contact[];
}
interface LinkDispatchProps {
  //makeCall: (contacts: Contact ) => void;
  receiveCall: (contacts: Contact) => void;
}
const mapStateToProps = (
  state: AppState,
  ownProps: HomePageProps
): LinkStateProps => ({
  contacts: state.contacts
});

const mapDispatchToProps = (
  dispatch: ThunkDispatch<any, any, AppActions>,
  ownProps: HomePageProps
): LinkDispatchProps => ({
  receiveCall: bindActionCreators(rec_call, dispatch)
});

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(HomePagePage);
