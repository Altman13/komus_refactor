import React from "react";
import { connect } from "react-redux";
import { get_contacts } from "../actions/"
import { Contact } from "../models";
import { AppState } from "../store"
import { Dispatch, bindActionCreators } from "redux";
import { AppActions } from "../models/actions";
import { ThunkDispatch } from "redux-thunk";

// interface HomePageProps {
//   id?: string;
//   color?: string;
// }

interface HomePageState {}
//type Props = HomePageProps & 
type Props = LinkStateProps & LinkDispatchProps;

export class HomePagePage extends React.Component<Props, HomePageState> {
  // constructor(props: Props) {
  //   super(props);
  //   this.state = { contact : '' };
  // }
  get_contact = () : void => {
    this.props.get_contacts();
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
              <p>{contact.fio}</p>
              <p>{contact.email}</p>
                Remove contact
              
            </div>
          ))}
          <button onClick={() => this.get_contact()}>Edit contact</button>
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
  get_contacts: () => void
}
const mapStateToProps = (
  state: AppState,
  //ownProps: HomePageProps
): LinkStateProps => ({
  contacts: state.contacts
});

const mapDispatchToProps = (
  dispatch: ThunkDispatch<any, any, AppActions>
): LinkDispatchProps => ({
  get_contacts: bindActionCreators(get_contacts, dispatch),
});

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(HomePagePage);

