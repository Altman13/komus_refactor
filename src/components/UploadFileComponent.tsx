import * as React from "react";
import CSS from "csstype";
import { Button } from "@material-ui/core";

const inputUploadFile: CSS.Properties = {
  display: "none",
};
export interface UploadFileComponentProps {
  url: string;
}
export interface UploadFileComponentState {
  file: any;
  err_text: string
  err : boolean
}
class UploadFileComponent extends React.Component<
  UploadFileComponentProps,
  UploadFileComponentState
> {
  constructor(props: UploadFileComponentProps) {
    super(props);
    this.state = { file: null, err : true , err_text : 'Выберете файл для загрузки' };
    this.handleFileChange = this.handleFileChange.bind(this);
    this.manageUploadedFile = this.manageUploadedFile.bind(this);
  }

  async manageUploadedFile() {
    const formData = new FormData();
    if (this.state.err!=true) {
      let fn: string = "file_upload";
      formData.append(fn, this.state.file);
      const response = await fetch(
        "http://localhost/komus_new/api/" + this.props.url,
        {
          method: "POST",
          body: formData,
        }
      ).then((response) => {
        if (response.status === 200) {
          console.log("SUCCESSS");
          this.setState({ file: null });
        } else if (response.status === 408) {
          console.log("SOMETHING WENT WRONG");
        }
      });
    }
  }

  //WARNING! To be deprecated in React v17. Use new lifecycle static getDerivedStateFromProps instead.
  componentWillReceiveProps(nextProps: UploadFileComponentProps) {
    this.setState({ file: null , err : true });
  }
  
  handleFileChange(event: React.ChangeEvent<HTMLInputElement>) {
    event.persist();
    if (event.target.files) {
      console.log(event.target.files[0]);
      this.setState({ file: event.target.files[0] ,err :false });
    }
  }
  render(): JSX.Element {
    return (
      <div>
        <input
          accept=".xls,.xlsx"
          style={inputUploadFile}
          id="file"
          multiple={true}
          type="file"
          onChange={this.handleFileChange}
        />
        <label htmlFor="file">
          <Button
            variant="outlined"
            color="primary"
            aria-label="upload picture"
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
        <div style={{ width: "100%", textAlign: "center", fontSize: 18 }}>
          {this.state.file ? this.state.file.name : null}
          {this.state.err ? this.state.err_text : null}
        </div>
        <Button
          variant="outlined"
          color="primary"
          style={{ width: "100%", margin: "auto", height: 55, marginTop: 5 }}
          onClick={this.manageUploadedFile}
        >
          Загрузить
        </Button>
      </div>
    );
  }
}
export default UploadFileComponent;
