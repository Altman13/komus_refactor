import React from "react";
import {
  createStyles,
  makeStyles,
  withStyles,
  Theme
} from "@material-ui/core/styles";
import NativeSelect from "@material-ui/core/NativeSelect";
import InputBase from "@material-ui/core/InputBase";

const BootstrapInput = withStyles((theme: Theme) =>
  createStyles({
    root: {
      "label + &": {
        marginTop: theme.spacing(3)
      }
    },
    input: {
      borderRadius: 4,
      position: "relative",
      backgroundColor: theme.palette.background.paper,
      border: "1px solid #ced4da",
      fontSize: 16,
      padding: "10px 26px 10px 12px",
      transition: theme.transitions.create(["border-color", "box-shadow"]),
      // Use the system font instead of the default Roboto font.
      fontFamily: [
        "-apple-system",
        "BlinkMacSystemFont",
        '"Segoe UI"',
        "Roboto",
        '"Helvetica Neue"',
        "Arial",
        "sans-serif",
        '"Apple Color Emoji"',
        '"Segoe UI Emoji"',
        '"Segoe UI Symbol"'
      ].join(","),
      "&:focus": {
        borderRadius: 4,
        borderColor: "#80bdff",
        boxShadow: "0 0 0 0.2rem rgba(0,123,255,.25)"
      }
    }
  })
)(InputBase);

const useStyles = makeStyles((theme: Theme) =>
  createStyles({
    margin: {
      margin: theme.spacing(1)
    }
  })
);

export default function CustomizedSelects() {
  const classes = useStyles();
  const [age, setAge] = React.useState("");
  const handleChange = (event: React.ChangeEvent<{ value: unknown }>) => {
    setAge(event.target.value as string);
  };
  return (
    <div>
        <NativeSelect style={{ width: "200px" }}
          id="demo-customized-select-native"
          value={age}
          onChange={handleChange}
          input={<BootstrapInput />}
        >
          <option value="" />
          <option value={10}>Раз</option>
          <option value={20}>Два</option>
          <option value={30}>Три</option>
        </NativeSelect>
    </div>
  );
}
