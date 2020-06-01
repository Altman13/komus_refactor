import * as React from "react"
import Grid from '@material-ui/core/Grid'
import Button from '@material-ui/core/Button'
import CSS from 'csstype'
import Hidden from '@material-ui/core/Hidden';
import IconButton from '@material-ui/core/IconButton';
import CheckCircleIcon from '@material-ui/icons/CheckCircle';
// const inputUploadFile: CSS.Properties= {
//     display: 'none',
// };

// const buttonUploadFile: CSS.Properties = {
//     margin: '8'
// };

// // component own props
// interface UploadFileOwnProps { }

// // component props
// interface UploadFileProps extends UploadFileOwnProps { }

// // component State
// interface UploadFileStateProps { }

// class UploadFileComponent extends React.Component<UploadFileProps, UploadFileStateProps>  {

//     // function to read file as binary and return
//     getFileFromInput(file: File): Promise<any> {
//         return new Promise(function (resolve, reject) {
//             const reader = new FileReader();
//             reader.onerror = reject;
//             reader.onload = function () { resolve(reader.result); };
//             reader.readAsBinaryString(file); // here the file can be read in different way Text, DataUrl, ArrayBuffer
//         });
//     }

//     manageUploadedFile(/*binary: String, */file: File) {
//         // do what you need with your file (fetch POST, ect ....)
//         //console.log(`The file size is ${binary.length}`);
//         console.log(`The file name is ${file.name}`);
//     }
//     test(){
//         console.log('test')
//     }
//     handleFileChange(event: React.ChangeEvent<HTMLInputElement>) {
//         // event.persist();
//         // if(event.target.files){
//         //Array.from(event.target.files).forEach(file => {
//             // this.getFileFromInput(event.target.files[0])
//             //     .then((binary) => {
//                     //if(event.target.files)
//                     //console.log(event.target.files[0])
//                     this.test()
//                     //this.manageUploadedFile(/*binary,*/ event.target.files[0]);
//                 // }).catch(function (reason) {
//                 //     console.log(`Error during upload ${reason}`);
//                 //     event.target.value = '' // to allow upload of same file if error occurs
//                 // })
//             //}
//             //)
//         //}
//     }


//     render(): JSX.Element {
//         return (
//             <Grid container>
//                 <Hidden only={['sm', 'lg']}>
//                 <Grid item xs={6} lg={1} style={{backgroundColor: "red"}}>
//                     <input accept="image/*,.pdf,.doc,.docx,.xls,.xlsx" style={inputUploadFile} id="file" multiple={true} type="file"
//                         onChange={this.handleFileChange} />
//                     <label htmlFor="file">
//                         <Button component="span" style={buttonUploadFile} /*{onClick={e => e.stopPropagation()}}*/>
//                             Upload
//                         </Button>
//                     </label>
//                 </Grid>
//                 </Hidden>
//             </Grid>
//         );
//     }
// }
const inputUploadFile: CSS.Properties= {
    display: 'none',
};

const buttonUploadFile: CSS.Properties = {
    margin: '8'
};
export interface UploadFileComponentProps {
    url: string
    text :string
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
                const reader = new FileReader();
                reader.onerror = reject;
                reader.onload = function () { resolve(reader.result); };
                reader.readAsBinaryString(file); // here the file can be read in different way Text, DataUrl, ArrayBuffer
            });
        }
     async manageUploadedFile(/*binary: String, */file: File) {
        // do what you need with your file (fetch POST, ect ....)
        //console.log(`The file size is ${binary.length}`);
            const formData  = new FormData();
            //for(const name in data) {
            let op='operators'
            formData.append(op, file);
            //}
            const response = await fetch('http://localhost/komus_new/api/'+this.props.url, {
            method: 'POST',
            body: formData
            });
        console.log(`The file name is ${file.name}`);
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
                    //console.log(event.target.files[0])
                    this.manageUploadedFile(/*binary,*/ event.target.files[0]);
                }).catch(function (reason) {
                    console.log(`Error during upload ${reason}`);
                    event.target.value = '' // to allow upload of same file if error occurs
                })
            })
        }
    }
    render() : JSX.Element { 
        return (
            <Grid container>
                <Hidden only={['sm', 'lg']}>
                <Grid item xs={6} lg={1} /*style={{backgroundColor: "red"}}*/>
                    <input accept="image/*,.pdf,.doc,.docx,.xls,.xlsx" style={inputUploadFile} id="file" multiple={true} type="file"
                        onChange={this.handleFileChange} />
                    <label htmlFor="file">
                        <IconButton color="primary" aria-label="upload picture" component="span">Загрузить {this.props.text}
                            <CheckCircleIcon />
                        </IconButton>
                        </label>
                        <span>{this.state.file}</span>
                </Grid>
                </Hidden>
            </Grid>
        );
    }
}

export default UploadFileComponent;


