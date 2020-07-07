import React from "react"
// import CSS from "csstype"
import { Button } from "@material-ui/core"
//import SpinnerComponent from './SpinnerComponent'
import { ajaxAction } from '../services'

// const inputUploadFile: CSS.Properties = {
//   display: "none",
// }
// var temp = 0
// export interface UploadFileComponentProps {
//   url: string
// }
// export interface UploadFileComponentState {
//   file: any
//   text: string
//   err : boolean
//   spinner : boolean
// }
// class UploadFileComponent extends React.Component<
//   UploadFileComponentProps,
//   UploadFileComponentState
// > {
//   constructor( props: UploadFileComponentProps ) {
//     super( props )
//     this.state = { file: null, err : true , text : 'Выберете файл для загрузки' , spinner : false }
//     this.handleFileChange = this.handleFileChange.bind(this)
//     this.manageUploadedFile = this.manageUploadedFile.bind(this)
//   }


export default function UploadFileComponent( url : string ){
  
  function handleFileChange( event: React.ChangeEvent<HTMLInputElement> ) {
    event.persist()
    if ( event.target.files ) {
      console.log( event.target.files[0] )
      this.setState({ file: event.target.files[0], err :false })
    }
  }
  
  async function manageUploadedFile( file : any ) {
    const formData = new FormData()
    if (this.state.err!=true) {
      let fn: string = "upload_file"
      formData.append( fn, file )
      let resp: any = ''
      const method: string = 'POST'
      resp = await ajaxAction( url, method, file )
  } 
    return (
      <div>
        <input
          accept=".xls,.xlsx"
          style={{ display : 'none' }}
          id="file"
          multiple={true}
          type="file"
          onChange={ handleFileChange }
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
          onClick={ () => manageUploadedFile( file ='test' ) }
        >Загрузить
        </Button>
      </div>
    )
  }
}