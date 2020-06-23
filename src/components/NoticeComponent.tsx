import React from "react";
import Snackbar from "@material-ui/core/Snackbar";
import MuiAlert, { AlertProps } from "@material-ui/lab/Alert";
import { makeStyles, Theme } from "@material-ui/core/styles";

function Alert(props: AlertProps) {
  return <MuiAlert elevation={6} variant="filled" {...props} />;
}

const useStyles = makeStyles((theme: Theme) => ({
  root: {
    width: "100%",
    "& > * + *": {
      marginTop: theme.spacing(2),
    },
  },
}));

export default function DefaultNotice(err : any ) {
  const classes = useStyles();
  const [open, setOpen] = React.useState(true);
  const [state, setState] = React.useState({
    vertical: 'top' as 'top',
    horizontal: 'center' as 'center',
  });
  const { vertical, horizontal } = state;
  const handleClose = (event?: React.SyntheticEvent, reason?: string) => {
    if (reason === "clickaway") {
      return;
    }
    setOpen(false);
  };
  console.log(err.err)
  return (
    <div className={classes.root}>
      { err.err ?
      <Snackbar open={open} autoHideDuration={6000} onClose={handleClose} anchorOrigin={{ vertical, horizontal }} key={vertical + horizontal} >
        <Alert  onClose={handleClose} severity="error">Произошла ошибка при выполнеии действия!</Alert>
      </Snackbar>
      :
      <Snackbar open={open} autoHideDuration={6000} onClose={handleClose} anchorOrigin={{ vertical, horizontal }} key={vertical + horizontal} >
          <Alert onClose={handleClose} severity="success">
          Действие выполнено успешно!
         </Alert>
      </Snackbar>
      }
    </div>
  );
}
