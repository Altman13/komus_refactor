import React, { Component } from "react"
export interface MailComponentProps {}
export interface MailComponentState {
  switch: boolean;
}
class MailComponent extends React.Component<
  MailComponentProps,
  MailComponentState
> {
  constructor(props: MailComponentProps) {
    super(props);
    this.state = { switch: false }
  }
  handleSwitchChange = () => {
    this.setState({ switch: !this.state.switch })
  }
  render() {
    return (
      <div className="custom-control custom-switch">
        <input
          type="checkbox"
          className="custom-control-input"
          id="customSwitches"
          checked={this.state.switch}
          onChange={() => this.handleSwitchChange()}
          readOnly
        />
        <label className="custom-control-label" htmlFor="customSwitches">
          Отправить коммерческое предложение
        </label>
      </div>
    )
  }
}

export default  MailComponent;