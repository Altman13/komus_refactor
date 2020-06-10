import React from "react";
import TextField from "@material-ui/core/TextField";
import Autocomplete from "@material-ui/lab/Autocomplete";
import { Button } from "@material-ui/core";
import Grid from '@material-ui/core/Grid'
var users = new Array();

// interface oper {
//   operators: string
// }

//TODO: все запросы перенести в сервисы
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
async function set_st_operator(value) {
  if (value) {
    let resp = "";
    try {
      await fetch("http://localhost/komus_new/api/user", {
        method: "PATCH",
        body: value.operators,
      })
        .then((response) => {
          return response.json();
        })
        .then((data) => {
          resp = data;
          return resp;
        });
    } catch (err) {
      console.log(err);
    }
  }
}
export default function ListOperators() {
  get_users();
  return (
    <div>
      <Grid item xs={12} lg={3} sm={4} md={4}>
      <Autocomplete
        id="combo-box-demo"
        onChange={(event, value) => set_st_operator(value)}
        options={users}
        getOptionLabel={(options) => options.operators}
        style={{ width: '100%', float: "left", margin: 'auto', marginBottom: 5 }}
        renderInput={(params) => (
          <TextField {...params} label="Выбрать оператора" variant="outlined" />
        )}
      />
      <Button
        variant="outlined"
        color="primary"
        style={{ width: '100%', margin: 'auto', height: 55 }}
        onClick={set_st_operator}
      >
        Назначить
      </Button>
      </Grid>
    </div>
  );
}
