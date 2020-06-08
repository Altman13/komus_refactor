/* eslint-disable no-use-before-define */
import React from 'react';
import TextField from '@material-ui/core/TextField';
import Autocomplete from '@material-ui/lab/Autocomplete';
import { Divider } from '@material-ui/core';

const get_users = (
    async () => {
      try {
        let resp=''
        await fetch("http://localhost/komus_new/api/user")
          .then((response) => {
            return response.json();
          })
          .then((data) => {
            resp = data
          });
        return resp
      } catch (err) {
        console.log(err);
      }
    }
  )

export default function ListOperators() {
  get_users()
  return (
    <Autocomplete
      id="combo-box-demo"
      options={temp}
      getOptionLabel={(option) => option.title}
      style={{ width: 300 }}
      renderInput={(params) =>
      <TextField {...params} label="Список операторов" variant="outlined"/>
      } 
    />
  );
}

// Top 100 films as rated by IMDb users. http://www.imdb.com/chart/top
const temp = [
  { title: 'The Shawshank Redemption'},
  { title: 'The Godfather'},
  { title: 'The Godfather: Part II'},
];
