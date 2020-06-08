import * as React from "react"
import Grid from '@material-ui/core/Grid'
import CSS from 'csstype'
import Hidden from '@material-ui/core/Hidden'
import IconButton from '@material-ui/core/IconButton'
import CheckCircleIcon from '@material-ui/icons/CheckCircle'

const inputUploadFile: CSS.Properties= {
    display: 'none',
}
export interface UploadFileComponentProps {
    url: string
    //text :string
}
export interface UploadFileComponentState {
    file: any
}
class UploadFileComponent extends React.Component<UploadFileComponentProps, UploadFileComponentState> {
    constructor(props: UploadFileComponentProps) {
        super(props);
        this.state = {file : null};
        this.handleFileChange = this.handleFileChange.bind(this)
        this.getFileFromInput = this.getFileFromInput.bind(this)
        this.manageUploadedFile = this.manageUploadedFile.bind(this)
    }

        getFileFromInput(file: File): Promise<any> {
            return new Promise(function (resolve, reject) {
                const reader = new FileReader()
                reader.onerror = reject
                reader.onload = function () { resolve(reader.result) }
                reader.readAsBinaryString(file) // here the file can be read in different way Text, DataUrl, ArrayBuffer
            });
        }
     async manageUploadedFile(/*binary: String, */file: File) {
            const formData  = new FormData()
            let op='operators'
            formData.append(op, file)
            const response = await fetch('http://localhost/komus_new/api/'+this.props.url, {
            method: 'POST',
            body: formData
            });
        console.log(`The file name is ${file.name}`)
        console.log(this.props.url)
        this.setState({file: file.name})
    }
        handleFileChange(event: React.ChangeEvent<HTMLInputElement>) {
        event.persist();
        if(event.target.files){

        Array.from(event.target.files).forEach(file => {
            if(event.target.files)
            this.getFileFromInput(event.target.files[0])
                .then((binary) => {
                    if(event.target.files)
                    this.manageUploadedFile(/*binary,*/ event.target.files[0]);
                }).catch(function (reason) {
                    console.log(`Error during upload ${reason}`)
                    event.target.value = ''
                })
            })
        }
    }
    render() : JSX.Element { 
        return (
            <Grid container>
                <Hidden only={['sm', 'lg']}>
                <Grid item xs={12} lg={2}>
                    <input accept=".xls,.xlsx" style={inputUploadFile} id="file" multiple={true} type="file"
                        onChange={this.handleFileChange} />
                    <label htmlFor="file">
                        <IconButton color="primary" aria-label="upload picture" component="span">Выбрать файл
                            {/* <CheckCircleIcon /> */}
                        </IconButton>
                        </label>
                        <span>{this.state.file}</span>
                </Grid>
                </Hidden>
            </Grid>
        )
    }
}
export default UploadFileComponent
