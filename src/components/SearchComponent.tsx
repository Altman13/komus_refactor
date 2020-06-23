import React from "react"
import { TextField } from "@material-ui/core"
interface State {

}

interface Props {

}
class SearchComponent extends React.Component<State, Props> {
    constructor(props) {
        super(props);
    }
    render() { 
        return ( <TextField id="outlined-basic" label="Поиск" variant="outlined" style={{width: "100%", marginBottom: "15px" }} />);
    }
}

export default SearchComponent
