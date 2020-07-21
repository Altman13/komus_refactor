import React from "react"
import Autocomplete from "@material-ui/lab/Autocomplete"
import * as core from "@material-ui/core"

import { ajaxAction } from '../services'

export default function ListOperators( users : any ) {

  function ChooseStOperator( operator ){
    //setOperator( users )
  }

  async function setStOperator( operator ) {
    if ( operator ) {
      const url : string = 'user'
      const method : string = 'PATCH'
      const resp : any = await ajaxAction( url, method , operator.operators )
      return resp
    }
  }
  return (
    <div>
      <core.Grid item xs = { 12 } lg = { 3 } sm = { 4 } md = { 4 }>
      <Autocomplete
        id="free-solo-demo"
        freeSolo
        options={users.users.map((option) => option.operators)}
        renderInput={(params) => (
          <core.TextField {...params} label="Выбрать оператора" margin="normal" variant="outlined" />
        )}
      />
      <core.Button
        variant = "outlined"
        color = "primary"
        style = {{ width: '100%', margin: 'auto', height: 55, marginBottom: 20 }}
        // onClick = { () => setStOperator( users ) }
      >
        Назначить
      </core.Button>
      </core.Grid>
    </div>  
  )
}
