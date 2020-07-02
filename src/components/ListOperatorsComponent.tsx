import React from "react"
import Autocomplete from "@material-ui/lab/Autocomplete"
import { Button, TextField, Grid } from "@material-ui/core"
import { ajaxAction } from '../services'

async function setStOperator( value ) {
  if ( value ) {
    let resp : any = ''
    const url : string = 'user'
    const method : string = 'PATCH'
    const data : any = value.operators
    resp = await ajaxAction( url, method , data )
    return resp
  }
}
let users: any[]
export default function ListOperators(operator) {
    users = operator.users
    return (
    <div>
      <Grid item xs={12} lg={3} sm={4} md={4}>
      <Autocomplete
        id="combo-box-demo"
        options={ users }
        getOptionLabel={(options) => options.operators}
        style={{ width: '100%', float: "left", margin: 'auto', marginBottom: 5 }}
        renderInput={( params ) => (
          <TextField { ...params } label="Выбрать оператора" variant="outlined" />
        )}
      />
      <Button
        variant="outlined"
        color="primary"
        style={{ width: '100%', margin: 'auto', height: 55, marginBottom: 20 }}
        onClick={ setStOperator }
      >
        Назначить
      </Button>
      </Grid>
    </div>
  );
}
