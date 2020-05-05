import React from "react"
import { Button, TextField } from "@material-ui/core"

// import { connect } from "react-redux"
// import { AppState } from "../store"
// import { bindActionCreators } from "redux"
// import { AppActions } from "../models/actions"
// import { ThunkDispatch } from "redux-thunk"

interface State {

}

interface Props {

}
//type Props = LinkStateProps & LinkDispatchProps;
class SearchComponent extends React.Component<State, Props> {
    constructor(props) {
        super(props);
    }
    render() { 
        return ( <TextField id="outlined-basic" label="Поиск" variant="outlined" />);
    }
}
// interface LinkStateProps {
//     searchstr: string
//   }
//   interface LinkDispatchProps {
//     searchinfo: () => string
//   }
//   const mapStateToProps = (state: AppState): LinkStateProps => ({
//   });
  
//   const mapDispatchToProps = (
//     dispatch: ThunkDispatch<any, any, AppActions>
//   ): LinkDispatchProps => ({
//     receiveCall: bindActionCreators(search, dispatch),
//   });
export default SearchComponent
//export default connect(mapStateToProps, mapDispatchToProps)(SearchComponent);