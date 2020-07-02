import * as React from "react"
import CSS from "csstype"
import { Button } from "@material-ui/core"
import SpinnerComponent from './SpinnerComponent'

const inputUploadFile: CSS.Properties = {
  display: "none",
};
var temp = 0
export interface UploadFileComponentProps {
  url: string;
}
export interface UploadFileComponentState {
  file: any;
  text: string
  err : boolean
  spinner : boolean
}
class UploadFileComponent extends React.Component<
  UploadFileComponentProps,
  UploadFileComponentState
> {
  constructor(props: UploadFileComponentProps) {
    super(props)
    this.state = { file: null, err : true , text : 'Выберете файл для загрузки' , spinner : false }
    this.handleFileChange = this.handleFileChange.bind(this)
    this.manageUploadedFile = this.manageUploadedFile.bind(this)
  }

  async manageUploadedFile() {
    const formData = new FormData()
    if (this.state.err!=true) {
      let fn: string = "upload_file"
      formData.append(fn, this.state.file)
      this.setState({ text : '', spinner : true, file : null })
      temp = 20
      const response = await fetch(
        "http://localhost/komus_new/api/" + this.props.url,
        {
          method: "POST",
          body: formData,
        }
      ).then(( response ) => {
        if ( response.status === 200 ) {
          console.log( "SUCCESSS" )
          temp = 0
          this.setState({ spinner : false, file: null, text : '' })
        } else if ( response.status === 500 ) {
          this.setState({ spinner : false })
          console.log( "SOMETHING WENT WRONG" )
        }
      })
    }
  }
componentWillReceiveProps (){
    this.setState({ file: null , err : true })
}

handleFileChange( event: React.ChangeEvent<HTMLInputElement> ) {
    event.persist()
    if ( event.target.files ) {
      console.log( event.target.files[0] )
      this.setState({ file: event.target.files[0], err :false })
    }
  }
  render(): JSX.Element {
    return (
      <div>
        <input
          accept=".xls,.xlsx"
          style={ inputUploadFile }
          id="file"
          multiple={true}
          type="file"
          onChange={ this.handleFileChange }
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
        <div style={{ width: "100%", textAlign: "center", fontSize: 18, padding: temp }}>
          { this.state.file ? this.state.file.name : null }
          { this.state.err ? this.state.text : null }
          { this.state.spinner ? <SpinnerComponent /> : null }
        </div>
        <Button
          variant="outlined"
          color="primary"
          style={{ width: "100%", margin: "auto", height: 55, marginTop: 5 }}
          onClick={ this.manageUploadedFile }
        >Загрузить
        </Button>
      </div>
    )
  }
}
export default UploadFileComponent