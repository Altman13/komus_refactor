/* eslint-disable no-use-before-define */
import React from "react";
import TextField from "@material-ui/core/TextField";
import Autocomplete from "@material-ui/lab/Autocomplete";
import { Divider } from "@material-ui/core";

var users = new Array();

// interface oper {
//   operators: string
// }

async function get_users() {
  try {
    await fetch("http://localhost/komus_new/api/user")
      .then((response) => {
        return response.json();
      })
      .then((data) => {
        users = data;
      });
  } catch (err) {
    console.log(err);
  }
}
export default function ListOperators() {
  get_users();
  return (
    <Autocomplete
      id="combo-box-demo"
      options={users}
      getOptionLabel={(options) => options.operators}
      style={{ width: 250, height: 100 }}
      renderInput={(params) => (
        <TextField {...params} label="Список операторов" variant="outlined" />
      )}
    />
  );
}
