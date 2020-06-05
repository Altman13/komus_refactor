/* eslint-disable no-use-before-define */
import React from 'react';
import TextField from '@material-ui/core/TextField';
import Autocomplete from '@material-ui/lab/Autocomplete';
import { Divider } from '@material-ui/core';

export default function ListOperators() {
  return (
    <Autocomplete
      id="combo-box-demo"
      options={temp}
      getOptionLabel={(option) => option.title}
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
