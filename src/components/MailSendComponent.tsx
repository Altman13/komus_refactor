import React, { Component } from "react"
import Checkbox from "@material-ui/core/Checkbox";
import FormControlLabel from "@material-ui/core/FormControlLabel";
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

export default  MailComponent;