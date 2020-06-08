import React from "react"
import TextField from "@material-ui/core/TextField"
import Autocomplete from "@material-ui/lab/Autocomplete"
import { Button } from "@material-ui/core"
var users = new Array()

// interface oper {
//   operators: string
// }

async function get_users() {
  try {
    await fetch("http://localhost/komus_new/api/user")
      .then((response) => {
        return response.json()
      })
      .then((data) => {
        users = data
      })
  } catch (err) {
    console.log(err)
  }
}
async function setStOperator(){
  console.log('st_operaotr')
}
export default function ListOperators() {
  get_users()
  return (
    <div>
    <Autocomplete
      id="combo-box-demo"
      options={users}
      getOptionLabel={(options) => options.operators}
      style={{ width: 250, float: 'left', marginLeft: 5 }}
      renderInput={(params) => (
        <TextField {...params} label="Список операторов" variant="outlined" />
      )}
    />
     <Button variant="outlined" color="primary" style={{ marginLeft: 5, height: 55 }} onClick={setStOperator}>
      Назначить
    </Button>
    </div>
  )
}
