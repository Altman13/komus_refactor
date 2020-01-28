import React, { useState, useEffect } from "react";
import TextField from "@material-ui/core/TextField";
import { createStyles, makeStyles, Theme } from "@material-ui/core/styles";
import Card from "@material-ui/core/Card";
import CardContent from "@material-ui/core/CardContent";
import CardActions from "@material-ui/core/CardActions";
import Button from "@material-ui/core/Button";
import CardHeader from "@material-ui/core/CardHeader";

const useStyles = makeStyles((theme: Theme) =>
  createStyles({
    container: {
      display: "flex",
      flexWrap: "wrap",
      width: 400,
      margin: `${theme.spacing(0)} auto`
    },
    loginBtn: {
      marginTop: theme.spacing(2),
      flexGrow: 1
    },
    header: {
      textAlign: "center",
      background: "#1e88e5",
      color: "#fff"
    },
    card: {
      marginTop: theme.spacing(10)
    }
  })
);

const Login = () => {
  const classes = useStyles();
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");
  const [isButtonDisabled, setIsButtonDisabled] = useState(true);
  const [helperText, setHelperText] = useState("");
  const [error, setError] = useState(false);

  useEffect(() => {
    if (username.trim() && password.trim()) {
      setIsButtonDisabled(false);
    } else {
      setIsButtonDisabled(true);
    }
  }, [username, password]);

  const handleLogin = () => {

    if (username === "abc@email.com" && password === "password") {
      setError(false)
      console.log('успешный вход')
      setHelperText("Успешный вход")
    } else {
      setError(true)
      setHelperText("Ошибка ввода логина или пароля")
      console.log('неуспешный вход')
    }
  };

  const handleKeyPress = (e: any) => {
    if (e.keyCode === 13 || e.which === 13) {
      isButtonDisabled || handleLogin();
    }
  };

  return (
    <React.Fragment>
      <form className={classes.container} noValidate autoComplete="off">
        <Card className={classes.card}>
          <CardHeader className={classes.header} title="КОМУС" />
          <CardContent>
            <div>
              <TextField
                error={error}
                fullWidth
                id="username"
                type="email"
                label="Логин"
                placeholder="Введите логин"
                margin="normal"
                onChange={e => setUsername(e.target.value)}
                onKeyPress={e => handleKeyPress(e)}
              />
              <TextField
                error={error}
                fullWidth
                id="password"
                type="password"
                label="Пароль"
                placeholder="Введите пароль"
                margin="normal"
                helperText={helperText}
                onChange={e => setPassword(e.target.value)}
                onKeyPress={e => handleKeyPress(e)}
              />
            </div>
          </CardContent>
          <CardActions>
            <Button
              variant="contained"
              size="large"
              color="secondary"
              className={classes.loginBtn}
              onClick={() => handleLogin()}
              disabled={isButtonDisabled}
            >
              Вход
            </Button>
          </CardActions>
        </Card>
      </form>
    </React.Fragment>
  );
};

export default Login;
