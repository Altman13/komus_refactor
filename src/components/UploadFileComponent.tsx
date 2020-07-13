import React from "react"
import { useDispatch } from "react-redux"

import { Button } from "@material-ui/core"

import SpinnerComponent from "./SpinnerComponent"
import { ajaxAction } from "../services"

export default function UploadFileComponent(urlApi: any) {
  const dispatch = useDispatch();
  const [data, setFormData] = React.useState<FormData | null>()
  const [spinner, setSpinnerVisible] = React.useState(false)

  function setFileToUpload(event: React.ChangeEvent<HTMLInputElement>) {
    event.persist()
    if ( event.target.files ) {
      const file: File = event.target.files[0]
      const formData = new FormData()
      let fn: string = "upload_file"
      formData.append( fn, file )
      setFormData( formData )
    }
  }

  async function UploadFile() {
    const { url } = urlApi
    const method: string = "POST"
    setSpinnerVisible(true)
    const ret: any = await ajaxAction( url, method, data )
    if ( ret ) {
      setSpinnerVisible( false )
      return ret
    }
  }

  return (
    <div>
      {spinner ? (
        <SpinnerComponent />
      ) : (
        <div>
          <input
            accept=".xls,.xlsx"
            style={{ display: "none" }}
            id="file"
            multiple={true}
            type="file"
            onChange={setFileToUpload}
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
            onClick={UploadFile}
            //onClick={() => dispatch( switchSpinnerVisible() )}
          >
            Загрузить
          </Button>
        </div>
      )}
    </div>
  )
}
