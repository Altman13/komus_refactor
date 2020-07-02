import React from "react"
import PacmanLoader from "react-spinners/PacmanLoader"

export default function SpinnerComponent(){
    return(
        <div>
        <div className="sweet-loading" style={{ float : 'left', paddingBottom: 20 }} >
        <PacmanLoader
            size={ 20 }
            color={ "#3f51b5" }
            loading={ true }
        />
        </div><span>Дождитесь окончания загрузки</span>
        </div>
    )
}
