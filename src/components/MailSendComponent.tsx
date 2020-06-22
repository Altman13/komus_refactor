import React, { Component } from "react"
import Checkbox from "@material-ui/core/Checkbox";
import FormControlLabel from "@material-ui/core/FormControlLabel";
import { connect } from "react-redux";
import { AppState } from "../store";
import { bindActionCreators } from "redux";
import { AppActions } from "../models/actions";
import { ThunkDispatch } from "redux-thunk";
import { Contact } from "../models";
import { send_mails } from "../actions/";
export interface MailComponentProps {
}
export interface MailComponentState {
  switch: boolean;
}
type Props = LinkStateProps & LinkDispatchProps;
class MailComponent extends React.Component<
  Props,
  MailComponentState
> {
  constructor(props: Props) {
    super(props);
    this.state = { switch: false }
  }
  handleSwitchChange = () => {
    this.setState({ switch: !this.state.switch })
    this.props.send_mail_kp(this.state.switch)
  }
  render() {
    return (
      
      <div className="custom-control custom-switch">
            <FormControlLabel
              className="custom-control-input"
              id="customSwitches"
              checked={this.state.switch}
              onChange={this.handleSwitchChange}
              value="end"
              control={<Checkbox color="primary" />}
              label="Отправить коммерческое предложение"
              labelPlacement="end"
            />
      </div>
    )
  }
}

//export default  MailComponent;

interface LinkStateProps {
  contacts: Contact;
}
interface LinkDispatchProps {
  send_mail_kp : (need_send: boolean) => void
  
}
const mapStateToProps = (state: AppState): LinkStateProps => ({
  contacts: state.contacts,
});

const mapDispatchToProps = (
  dispatch: ThunkDispatch<any, any, AppActions>
): LinkDispatchProps => ({
  send_mail_kp: bindActionCreators(send_mails, dispatch),
});

export default connect(mapStateToProps, mapDispatchToProps)(MailComponent);
