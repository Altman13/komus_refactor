export async function ajaxAction(
  url: string,
  method: string,
  data: any = undefined
) {
  var ret = "";
  try {
    if (data) {
      data = JSON.stringify({ data });
    }
    await fetch("http://localhost/komus_new/api/" + url, {
      method: method,
      body: data,
      mode: "cors",
      cache: "no-cache",
      credentials: "same-origin",
      headers: {
        "Content-Type": "application/json",
      },
      redirect: "follow",
      referrerPolicy: "no-referrer",
    })
      .then((response) => {
        return response.json();
      })
      .then((data) => {
        ret = data;
      });
  } catch (err) {
    console.log(err);
  }
  return ret;
}
// .then(( response ) => {
//     if ( response.status === 200 ) {
//       console.log( "SUCCESSS" )
//       this.setState({ spinner : false, file: null, text : '' })
//     } else if ( response.status === 500 ) {
//       this.setState({ spinner : false })
//       console.log( "SOMETHING WENT WRONG" )
//     }
//   })

export async function ajaxActionUploadFile( url: string, method: string, data: any = undefined ) {
    var ret = "";
    try {
    await fetch("http://localhost/komus_new/api/" + url, {
        method: "POST",
        body: data,
        mode: "cors",
        cache: "no-cache",
        credentials: "same-origin",
        headers: {
        "Content-Type":
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        Accept: "application/json",
        type: "formData",
        },
        redirect: "follow",
        referrerPolicy: "no-referrer",
    })
    .then((response) => {
        return response.json();
    })
    .then((data) => {
        ret = data
    })
    } catch (err) {
    console.log(err)
    }
    return ret
}
