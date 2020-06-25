import React from "react"
import { withStyles, Radio, FormControlLabel} from "@material-ui/core"
import { green } from "@material-ui/core/colors"

const GreenRadio = withStyles({
  root: {
    color: green[400],
    "&$checked": {
      color: green[600],
    },
  },
  checked: {},
})((props) => <Radio color="default" {...props} />);

export default function RadioButtons() {
  const [selectedValue, setSelectedValue] = React.useState("a");

  const handleChange = (event) => {
    setSelectedValue(event.target.value);
  };

  return (
    <div>
      <FormControlLabel
        value="start"
        control={
          <Radio
            checked={selectedValue === "a"}
            onChange={handleChange}
            value="a"
            name="radio-button-demo"
            inputProps={{ "aria-label": "A" }}
            color="primary"
          />
        }
        label="Значение 1"
        labelPlacement="start"
      />
      <Radio
        checked={selectedValue === "b"}
        onChange={handleChange}
        value="b"
        name="radio-button-demo"
        inputProps={{ "aria-label": "B" }}
      />

      <Radio
        checked={selectedValue === "d"}
        onChange={handleChange}
        value="d"
        color="default"
        name="radio-button-demo"
        inputProps={{ "aria-label": "D" }}
      />
      <Radio
        checked={selectedValue === "e"}
        onChange={handleChange}
        value="e"
        color="default"
        name="radio-button-demo"
        inputProps={{ "aria-label": "E" }}
        size="small"
      />
    </div>
  );
}
