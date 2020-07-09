import React from "react"
import { useDispatch } from "react-redux"

import { Button } from "@material-ui/core"

import { switchSpinnerVisible } from "../actions"
import { ajaxActionUploadFile } from '../services'

export default function UploadFileComponent( urlApi : any ){
  
  const dispatch = useDispatch()
  const [data, setFormData] = React.useState<FormData | null>()
  
  function setFileToUpload( event: React.ChangeEvent<HTMLInputElement> ) {
    event.persist()
    if(event.target.files){
    const file = event.target.files[0]
    const formData = new FormData()
    formData.append( 'upload_file', file, file.name )
    setFormData( formData )
  }
}
  
  async function UploadFile( ) {
    const { url } = urlApi
    const method: string ='POST'
    let ret: any = await ajaxActionUploadFile( url, method, data )
    // return ret
}
    return (
      <div>
        <input
          accept=".xls,.xlsx"
          style={{ display : 'none' }}
          id="file"
          multiple={true}
          type="file"
          onChange={ setFileToUpload }
        />
        <label htmlFor="file">
          <Button
            variant="outlined"
            color="primary"
            aria-label="upload file"
            component="span"
            style={{
              width: "100%",
              margin: "auto",
              height: 55,
              marginBottom: "5",
            }}
          >
            Выбрать файл
          </Button>
        </label>

        <Button
          variant="outlined"
          color="primary"
          style={{ width: "100%", margin: "auto", height: 55, marginTop: 5 }}
          //onClick={ UploadFile }
          onClick={() => dispatch( switchSpinnerVisible() )}
        >Загрузить
        </Button>
      </div>
    )
  }
  
