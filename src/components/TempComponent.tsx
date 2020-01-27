import * as React from "react"
import { connect } from 'react-redux'
import Container from '@material-ui/core/Container'
import Typography from '@material-ui/core/Typography'
import Button from '@material-ui/core/Button'
import CssBaseline from '@material-ui/core/CssBaseline'
import TextField from '@material-ui/core/TextField'
//import { withStyles } from '@material-ui/core/styles'
import FormControlLabel from '@material-ui/core/FormControlLabel'
import Checkbox from '@material-ui/core/Checkbox'
//import { withRouter } from 'react-router-dom'

//import { AppState, openSession, session } from './Store'
//import { styles } from './LoginStyles'
//import { Configuration } from './api/configuration'
//import { LoginApi } from './api'

//import Logo from '../assets/Logo-large.png'

interface Props {
    classes: any
    //openSession: typeof openSession
    // history: any
    // location: any
    //session: session
}

interface State {
    //endpoint: string
    username: string
    password: string
    submitted: boolean
    failure: boolean
    persistent: boolean
}

class LoginTemp extends React.Component<Props, State> {

    state: State

    constructor(props : Props) {
        super(props)
        this.state = {
            //endpoint: this.props.session.endpoint,
            username: "",
            password: "",
            submitted: false,
            failure: false,
            persistent: false
        }
    }

    handleChange(e : React.ChangeEvent<HTMLInputElement>) {
        const { name, value } = e.target;
        switch (name) {
            // case "endpoint":
            //     this.setState({ endpoint: value })
            //     break
            case "username":
                this.setState({ username: value })
                break
            case "password":
                this.setState({ password: value })
                break
            case "persistent":
                this.setState({ persistent: Boolean(value) })
                break
        }
    }

    handleSubmit(e : React.FormEvent<HTMLFormElement>) {
        e.preventDefault();

        this.setState({ submitted: true })

        if (!this.state.username || !this.state.password) {
            return
        }
        console.log(this.state.username + ' ' + this.state.password)
        fetch('https://jsonplaceholder.typicode.com/todos/1') 
        .then(response => response.json())
        .then(response => console.log(response))
         //.then(response => this.setState({ 
        // }))
        // .catch(error => this.setState({ 
          
        // }));
        // var endpoint = this.state.endpoint || this.props.session.endpoint

        // var conf = new Configuration({ basePath: endpoint })
        // var api = new LoginApi(conf)
        
        // api.login(this.state.username, this.state.password)
        //     .catch(() => {
        //         this.setState({ failure: true })
        //     })
        //     .then(response => {
        //         if (response) {
        //             this.setState({ failure: false })
        //             return response.json()
        //         } else {
        //             this.setState({ failure: true })
        //         }
        //     })
        //     .then(data => {
        //         if (data) {
        //             this.props.openSession(endpoint, this.state.username, data.Token, data.Permissions, this.state.persistent)

        //             var from = "/"
        //             if (this.props.location.state && this.props.location.state.from !== "/login") {
        //                 from = this.props.location.state.from
        //             }
        //             this.props.history.push(from)
        //         }
        //     })
    }

    render() {
        const { classes } = this.props

        return (
            <Container component="main" maxWidth="xs">
                <CssBaseline />
                <div className={classes.logo}>
                    {/* <img src={Logo} alt="logo" className={classes.logoImg} /> */}
                    {/* <Typography className={classes.logoTitle} variant="h3" component="h3">
                        КОМУС
                    </Typography> */}
                </div>
                <div className={classes.paper}>
                    {this.state.failure &&
                        <React.Fragment>
                            <div className={classes.failure}>Неудачный вход</div>
                            <div className={classes.failure}>Некорректные логин/пароль</div>
                        </React.Fragment>
                    }
                    <form className={classes.form} noValidate onSubmit={this.handleSubmit.bind(this)}>
                        {/* <TextField
                            variant="outlined"
                            margin="normal"
                            required
                            fullWidth
                            id="endpoint"
                            label="Endpoint"
                            name="endpoint"
                            //autoComplete="endpoint"
                            //autoFocus
                            //value={this.state.endpoint}
                            onChange={this.handleChange.bind(this)}
                        /> */}
                        {/* {this.state.submitted && !this.state.endpoint &&
                            <div className={classes.error}>Endpoint is required</div>
                        } */}
                        <TextField
                            variant="outlined"
                            margin="normal"
                            required
                            fullWidth
                            id="username"
                            label="Логин оператора"
                            name="username"
                            //autoComplete="username"
                            //autoFocus
                            value={this.state.username}
                            onChange={this.handleChange.bind(this)}
                        />
                        {this.state.submitted && !this.state.username &&
                            <div className={classes.error}>Требуется логин оператора</div>
                        }
                        <TextField
                            variant="outlined"
                            margin="normal"
                            required
                            fullWidth
                            name="password"
                            label="Пароль оператора"
                            type="password"
                            id="password"
                            //autoComplete="current-password"
                            value={this.state.password}
                            onChange={this.handleChange.bind(this)}
                        />
                        {this.state.submitted && !this.state.password &&
                            <div className={classes.error}>Требуется пароль</div>
                        }
                        <FormControlLabel
                            control={<Checkbox value="remember" color="primary" />}
                            label="Запомнить меня"
                            name="persistent"
                            value={true}
                            // onChange={this.handleChange.bind(this)}
                        />
                        <Button
                            type="submit"
                            fullWidth
                            variant="contained"
                            color="primary"
                            className={classes.submit}
                        >
                            Вход
                        </Button>
                    </form>
                </div>
            </Container>
        )
    }
}

// export const mapStateToProps = (state: AppState) => ({
//     session: state.session
// })

// export const mapDispatchToProps = ({
//     openSession
// })

// export default withStyles(styles)(connect(mapStateToProps, mapDispatchToProps)(withRouter(Login)))
export default LoginTemp
