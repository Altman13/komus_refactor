import React from "react"
import Autocomplete from "@material-ui/lab/Autocomplete"
import * as core from "@material-ui/core"

import { ajaxAction } from '../services'

export default function ListOperators( operator ) {
  
  const [oper, setOperator] = React.useState( "" )
  
  function ChooseStOperator( operator ){
    setOperator( operator )
  }

  async function setStOperator( operator ) {
    if ( operator ) {
      let resp : any = ''
      const url : string = 'user'
      const method : string = 'PATCH'
      resp = await ajaxAction( url, method , operator.operators )
      return resp
    }
  }

  const users = Object.keys( operator.users ).map(function( key ) {
    return operator.users[key];
  })

  return (
    <div>
      <core.Grid item xs = { 12 } lg = { 3 } sm = { 4 } md = { 4 }>
      <Autocomplete
        id = "combo-box-demo"
        onChange = {( event, value ) => ChooseStOperator( value )}
        options = { users }
        getOptionLabel = {( options ) => options.operators }
        style = {{ width: '100%', float: "left", margin: 'auto', marginBottom: 5 }}
        renderInput = {( params ) => (
          <core.TextField { ...params } label = "Выбрать оператора" variant = "outlined" />
        )}
      />
      <core.Button
        variant = "outlined"
        color = "primary"
        style = {{ width: '100%', margin: 'auto', height: 55, marginBottom: 20 }}
        onClick = { () => setStOperator( oper ) }
      >
        Назначить
      </core.Button>
      </core.Grid>
    </div>
  )
}
