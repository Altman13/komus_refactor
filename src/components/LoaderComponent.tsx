import React from "react"
import { css } from "@emotion/core"
import PacmanLoader from "react-spinners/PacmanLoader"

const override = css`
    display: block;
    margin: 0 auto;
    border-color: red;`

    export interface LoaderComponentProps {

}

export interface LoaderComponentState {
    loading: boolean
}

class LoaderComponent extends React.Component<LoaderComponentProps,LoaderComponentState> {
    constructor(props: LoaderComponentProps) {
        super(props)
        this.state = { loading: true }
    }
    render() {
    return (
        <div className="sweet-loading">
        <PacmanLoader
            css={override}
            size={20}
            color={"#3f51b5"}
            loading={this.state.loading}
        />
        </div>
        )
    }
}

export default LoaderComponent;
