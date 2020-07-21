import React from "react"
import Autocomplete from "@material-ui/lab/Autocomplete"
import * as core from "@material-ui/core"

import { ajaxAction } from '../services'

export default function ListOperators( data : any ) {
  const [oper, setOperator] = React.useState( "" )
  const { users } = data
  function ChooseStOperator( operator ){
    setOperator( operator )
  }

  async function setStOperator( ) {
    console.log('test')
    if ( oper ) {
      const url : string = 'user'
      const method : string = 'PATCH'
      const resp : any = await ajaxAction( url, method , oper )
      return resp
    }
  }
  return (
    <div>
      <core.Grid item xs = { 12 } lg = { 3 } sm = { 4 } md = { 4 }>
      <Autocomplete
        id="operators"
        freeSolo
        onChange = {( event, value ) => ChooseStOperator( value )}
        options={ users.map(( option)  => option.operators )}
        renderInput={(params) => (
          <core.TextField {...params} label="Выбрать оператора" margin="normal" variant="outlined" />
        )}
      />
      <core.Button
        variant = "outlined"
        color = "primary"
        style = {{ width: '100%', margin: 'auto', height: 55, marginBottom: 20 }}
        onClick = { () => setStOperator( ) }
      >
        Назначить
      </core.Button>
      </core.Grid>
    </div>  
  )
}
