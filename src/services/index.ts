const ret = {
    data: '',
    status_code: '',
    error: '',
}
//TODO: дописать отправку сообщения об ошибке на почту 
export async function ajaxAction( url : string, method : string, data? : any ) {
    try {
        if ( data ) {
            data = JSON.stringify({ data })
        }
        await fetch('http://localhost/komus_new/api/' + url, {
            method: method,
            body: data,
            mode: 'cors',
            cache: 'no-cache',
            credentials: 'same-origin',
            headers: {
            'Content-Type': 'application/json',
            },
            redirect: 'follow',
            referrerPolicy: 'no-referrer',
        })
            .then(( response ) => {
                if ( response.status === 200 ) {
                    ret.status_code = response.status.toString()
                    return response.json()        
                } else if ( response.status === 500 ) {
                    ret.status_code = response.status.toString()
                }
            })
            .then((data) => {
            ret.data = data
            })
    } catch (err) {
        ret.error = err
        console.log(err)
    }
    return ret
}

export async function ajaxActionUploadFile( url : string, method : string, data? : any ) {
    try {
        await fetch('http://localhost/komus_new/api/' + url, {
            method: 'POST',
            body: data,
        })
        .then(( response ) => {
            if ( response.status === 200 ) {
                ret.status_code = response.status.toString()
                return response.json()        
            } else if ( response.status === 500 ) {
                ret.status_code = response.status.toString()
            }
        })
        .then(( data ) => {
            ret.data = data
        })
    } catch ( err ) {
        ret.error = err
        console.log( err )
    }
    return ret
    }
