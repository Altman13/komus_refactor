import * as React from "react";
import Grid from "@material-ui/core/Grid";
import CSS from "csstype";
import Hidden from "@material-ui/core/Hidden";
import IconButton from "@material-ui/core/IconButton";
import { Button } from "@material-ui/core";
import CheckCircleIcon from "@material-ui/icons/CheckCircle";

const inputUploadFile: CSS.Properties = {
  display: "none",
};
export interface UploadFileComponentProps {
  url: string;
  //text :string
}
export interface UploadFileComponentState {
  file: any;
}
class UploadFileComponent extends React.Component<
  UploadFileComponentProps,
  UploadFileComponentState
> {
  constructor(props: UploadFileComponentProps) {
    super(props);
    this.state = { file: null };
    this.handleFileChange = this.handleFileChange.bind(this);
    this.getFileFromInput = this.getFileFromInput.bind(this);
    this.manageUploadedFile = this.manageUploadedFile.bind(this);
  }

  // getFileFromInput(file: File): Promise<any> {
  //   this.setState({ file })
  //   return new Promise(function (resolve, reject) {
  //     const reader = new FileReader();
  //     reader.onerror = reject;
  //     reader.onload = function () {
  //       resolve(reader.result);
  //     };
  //     reader.readAsBinaryString(file); // here the file can be read in different way Text, DataUrl, ArrayBuffer
  //   });
  // }

  getFileFromInput(file: File) {
    if (file) {
      this.setState({ file: file });
      console.log(this.state.file);
    }
  }
  async manageUploadedFile() {
    const formData = new FormData();
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
        //return response.json();
        this.setState({file : null })
      } else if (response.status === 408) {
        console.log("SOMETHING WENT WRONG");
        //this.setState({ requestFailed: true })
      }
    });
    //console.log(`The file name is ${this.state.file.name}`);
    //console.log(this.props.url);
  }

  //WARNING! To be deprecated in React v17. Use new lifecycle static getDerivedStateFromProps instead.
  componentWillReceiveProps(nextProps: UploadFileComponentProps) {
    this.setState({ file: null });
  }
  //   manageUploadedFile(/*binary: String, */ file: File) {
  //   const formData = new FormData();
  //   let fn: string = "upload_file";
  //   formData.append(fn, file);
  //   const response = fetch(
  //     "http://localhost/komus_new/api/" + this.props.url,
  //     {
  //       method: "POST",
  //       body: formData,
  //     }
  //   );
  //   console.log(`The file name is ${file.name}`);
  //   console.log(this.props.url);
  //   this.setState({ file: file.name });
  // }
  // handleFileChange(event: React.ChangeEvent<HTMLInputElement>) {
  //   event.persist();
  //   if (event.target.files) {
  //     Array.from(event.target.files).forEach((file) => {
  //       if (event.target.files)
  //         this.getFileFromInput(event.target.files[0])
  //           .then((binary) => {
  //             if (event.target.files)
  //               this.manageUploadedFile(/*binary,*/ event.target.files[0]);
  //           })
  //           .catch(function (reason) {
  //             console.log(`Error during upload ${reason}`);
  //             event.target.value = "";
  //           });
  //     });
  //   }
  // }
  handleFileChange(event: React.ChangeEvent<HTMLInputElement>) {
    event.persist();
    if (event.target.files) {
      console.log(event.target.files[0]);
      this.setState({ file: event.target.files[0] });
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
