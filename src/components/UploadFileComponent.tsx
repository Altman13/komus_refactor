import React from "react"
import { Button } from "@material-ui/core"

//import { ajaxAction } from '../services'

var file
export default function UploadFileComponent( urlApi : any ){

  //const [fileData, setFileData] = React.useState<File | null>();
  
  function setFileToUpload( event: React.ChangeEvent<HTMLInputElement> ) {
    event.persist()
    if(event.target.files){
    //setFileData(event.target.files[0])
    file=event.target.files[0]
    }
  }
  
  async function UploadFile( ) {
    const formData = new FormData()
    formData.append( "file_upload", file )
    const { url } = urlApi
    fetch('http://localhost/komus_new/api/'+ url, { 
    method : "POST",
    body : formData ,
    mode : "cors",
    cache : "no-cache",
    credentials : "same-origin",
    headers: {
      "Content-Type": "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
      "Accept": "application/json",
      "type": "formData"
    },
    redirect : "follow",
    referrerPolicy : "no-referrer",
  }).then(
    response => response.json()
  ).then(
    success => console.log(success)
  ).catch(
    error => console.log(error)
  )
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
          onClick={ UploadFile }
        >Загрузить
        </Button>
      </div>
    )
  }
