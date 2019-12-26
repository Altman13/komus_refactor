import React from "react";
import { connect } from "react-redux";
import { startRemoveCall, startEditCall } from "../actions/";
import { call } from "../models";
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
  onEdit = (call: call) => {
    this.props.startEditCall(call);
  };
  onRemove = (id: string) => {
    this.props.startRemoveCall(id);
  };
  render() {
    const { call } = this.props;
    return (
      <div>
        <h1>call Page</h1>
        <div>
          {call.map(call => (
            <div>
              <p>{call.id}</p>
              <p>{call.fio_lpr}</p>
              <p>{call.mail_lpr}</p>
              <button onClick={() => this.onRemove(String(call.id))}>
                Remove call
              </button>
              <button onClick={() => this.onEdit(call)}>Edit call</button>
            </div>
          ))}
        </div>
      </div>
    );
  }
}

interface LinkStateProps {
  call: call[];
}
interface LinkDispatchProps {
  start: (call: call) => void;
  startRemoveCall: (id: string) => void;
}

const mapStateToProps = (
  state: AppState,
  ownProps: HomePageProps
): LinkStateProps => ({
    call: state.calls
});

const mapDispatchToProps = (
  dispatch: ThunkDispatch<any, any, AppActions>,
  ownProps: HomePageProps
): LinkDispatchProps => ({
    startEditCall: bindActionCreators(startEditCall, dispatch),
  startRemoveCall: bindActionCreators(startRemoveCall, dispatch)
});

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(HomePagePage);