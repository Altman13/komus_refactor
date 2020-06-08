import * as React from "react";
import AppBar from "@material-ui/core/AppBar"
import CssBaseline from "@material-ui/core/CssBaseline"
import Divider from "@material-ui/core/Divider"
import Drawer from "@material-ui/core/Drawer"
import Hidden from "@material-ui/core/Hidden"
import IconButton from "@material-ui/core/IconButton"
import List from "@material-ui/core/List"
import ListItem from "@material-ui/core/ListItem"
import ListItemIcon from "@material-ui/core/ListItemIcon"
import ListItemText from "@material-ui/core/ListItemText"
import MenuIcon from "@material-ui/icons/Menu"
import Toolbar from "@material-ui/core/Toolbar"
import Typography from "@material-ui/core/Typography"
import {
  makeStyles,
  useTheme,
  Theme,
  createStyles,
} from "@material-ui/core/styles";
import PersonAddIcon from "@material-ui/icons/PersonAdd";
import { Link } from "react-router-dom";

import {
  BrowserRouter as Router,
  Switch,
  Route,
  Redirect
} from "react-router-dom"
const drawerWidth = 240;
const useStyles = makeStyles((theme: Theme) =>
  createStyles({
    root: {
      display: "flex",
    },
    drawer: {
      [theme.breakpoints.up("sm")]: {
        width: drawerWidth,
        flexShrink: 0,
      },
    },
    appBar: {
      [theme.breakpoints.up("sm")]: {
        width: `calc(100% - ${drawerWidth}px)`,
        marginLeft: drawerWidth,
      },
    },
    menuButton: {
      marginRight: theme.spacing(2),
      [theme.breakpoints.up("sm")]: {
        display: "none",
      },
    },
    toolbar: theme.mixins.toolbar,
    drawerPaper: {
      width: drawerWidth,
    },
    content: {
      flexGrow: 1,
      padding: theme.spacing(3),
    },
  })
);
interface Props {
  //classes: any;
  //openSession: typeof openSession
  // history: any
  // location: any
  //session: session
}

interface State {
  username: string;
  password: string;
  submitted: boolean;
  failure: boolean;
  token : string
}
const classes = useStyles()
class LoginComponent extends React.Component<Props, State> {
  state: State;

  constructor(props: Props) {
    super(props);
    this.state = {
      token : "",
      username: "",
      password: "",
      submitted: false,
      failure: false,
    };
  }

  handleChange(e: React.ChangeEvent<HTMLInputElement>) {
    const { name, value } = e.target;
    switch (name) {
      case "username":
        this.setState({ username: value });
        break;
      case "password":
        this.setState({ password: value });
        break;
    }
  }

  handleSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    this.setState({ submitted: true });
    if (!this.state.username || !this.state.password) {
      return;
    }
    const data = {
      username: this.state.username,
      userpassword: this.state.password,
    };
    const url = "http://localhost/komus_new/api/login";

    async function login(url = "", data = {}) {
      // Default options are marked with *
      const response = await fetch(url, {
        method: "POST", // *GET, POST, PUT, DELETE, etc.
        mode: "cors", // no-cors, *cors, same-origin
        cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
        credentials: "same-origin", // include, *same-origin, omit
        headers: {
          "Content-Type": "application/json",
          // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: "follow", // manual, *follow, error
        referrerPolicy: "no-referrer", // no-referrer, *client
        body: JSON.stringify(data), // body data type must match "Content-Type" header
      });
      return await response.json(); // parses JSON response into native JavaScript objects
    }
    login(url, data)
      .then((data) => {
        console.log(data); 
        //TODO: tokenExpiry
        localStorage.setItem('token', data.user_token)
        localStorage.setItem('token_exp', data.token_exp)
        localStorage.setItem('user_group', data.user_group)
        console.log('localStrorage :>> ', localStorage);
      })
      .catch(() => {
        this.setState({ failure: true })
      })
  }

  render() {
    //const { classes } = this.props;

        return (
            <div className={classes.root}>
              <CssBaseline />
              <AppBar position="fixed" className={classes.appBar}>
                <Toolbar>
                  <IconButton
                    color="inherit"
                    aria-label="open drawer"
                    edge="start"
                    
                    className={classes.menuButton}
                  >
                    <MenuIcon />
                  </IconButton>
                  <Typography variant="h6" noWrap>
                    Панель управления
                  </Typography>
                </Toolbar>
              </AppBar>
              <nav className={classes.drawer} aria-label="mailbox folders">
                {/* The implementation can be swapped with js to avoid SEO duplication of links. */}
                <Hidden smUp implementation="css">
                  <Drawer
                    classes={{
                      paper: classes.drawerPaper,
                    }}
                    ModalProps={{
                      keepMounted: true, // Better open performance on mobile.
                    }}
                  >
                    
                  </Drawer>
                </Hidden>
                <Hidden xsDown implementation="css">
                  <Drawer
                    classes={{
                      paper: classes.drawerPaper,
                    }}
                    variant="permanent"
                    open
                  >
             
                  </Drawer>
                </Hidden>
              </nav>
              <main className={classes.content}>
                <div className={classes.toolbar} />
             
                <Typography paragraph>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                  eiusmod tempor incididunt ut labore et dolore magna aliqua. Rhoncus
                  dolor purus non enim praesent elementum facilisis leo vel. Risus at
                  ultrices mi tempus imperdiet. Semper risus in hendrerit gravida rutrum
                  quisque non tellus. Convallis convallis tellus id interdum velit
                  laoreet id donec ultrices. Odio morbi quis commodo odio aenean sed
                  adipiscing. Amet nisl suscipit adipiscing bibendum est ultricies
                  integer quis. Cursus euismod quis viverra nibh cras. Metus vulputate
                  eu scelerisque felis imperdiet proin fermentum leo. Mauris commodo
                  quis imperdiet massa tincidunt. Cras tincidunt lobortis feugiat
                  vivamus at augue. At augue eget arcu dictum varius duis at consectetur
                  lorem. Velit sed ullamcorper morbi tincidunt. Lorem donec massa sapien
                  faucibus et molestie ac.
                </Typography>
                <Typography paragraph>
                  Consequat mauris nunc congue nisi vitae suscipit. Fringilla est
                  ullamcorper eget nulla facilisi etiam dignissim diam. Pulvinar
                  elementum integer enim neque volutpat ac tincidunt. Ornare suspendisse
                  sed nisi lacus sed viverra tellus. Purus sit amet volutpat consequat
                  mauris. Elementum eu facilisis sed odio morbi. Euismod lacinia at quis
                  risus sed vulputate odio. Morbi tincidunt ornare massa eget egestas
                  purus viverra accumsan in. In hendrerit gravida rutrum quisque non
                  tellus orci ac. Pellentesque nec nam aliquam sem et tortor. Habitant
                  morbi tristique senectus et. Adipiscing elit duis tristique
                  sollicitudin nibh sit. Ornare aenean euismod elementum nisi quis
                  eleifend. Commodo viverra maecenas accumsan lacus vel facilisis. Nulla
                  posuere sollicitudin aliquam ultrices sagittis orci a.
                </Typography>
              </main>
            </div>
        )
    }
}
export default LoginComponent;
