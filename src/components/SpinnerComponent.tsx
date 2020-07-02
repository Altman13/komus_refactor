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

export default class SpinnerComponent extends React.Component<LoaderComponentProps,LoaderComponentState> {
    constructor(props: LoaderComponentProps) {
        super(props)
        this.state = { loading: true }
    }
    render() {
    return (
        <div>
        <div className="sweet-loading" style={{ float : 'left', paddingBottom: 20 }} >
        <PacmanLoader
            css={ override }
            size={ 20 }
            color={ "#3f51b5" }
            loading={ this.state.loading }
        />
        </div><span>Дождитесь окончания загрузки</span>
        </div>
        )
    }
}

