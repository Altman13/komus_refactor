import React from "react"
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
import LocalAirportRoundedIcon from "@material-ui/icons/LocalAirportRounded";
import PeopleAltIcon from "@material-ui/icons/PeopleAlt";
import WorkOutlineIcon from "@material-ui/icons/WorkOutline";
import ShowChartIcon from "@material-ui/icons/ShowChart";
import ListOperators from './ListOperatorsComponent'
import UploadFileComponent from './UploadFileComponent'
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

interface DashBoardComponentProps {
  /**
   * Injected by the documentation to work in an iframe.
   * You won't need it on your project.
   */
  container?: Element;
}
//TODO: разобраться как правильно работать с хуками
export function DashBoardComponent(props: DashBoardComponentProps) {
  const { container } = props;
  const classes = useStyles();
  const theme = useTheme();
  const [mobileOpen, setMobileOpen] = React.useState(false);
  const handleDrawerToggle = () => {
    setMobileOpen(!mobileOpen);
  }
  const [url, setUrl] = React.useState("");
  const [text, setText] = React.useState("");
  const [oper, setOper] = React.useState(false);
  const setBaseUrl = () => {
    console.log('base loaded')
    setUrl("base")
    setText("базу")
    setOper(false)
  }
  const setUserUrl = () => {
    console.log('operator loaded')
    setUrl("user")
    setText("пользователей")
    setOper(false)
  }

const setOperator = () =>{
  console.log('назначить старших')
  setOper(true)
  setText("операторов")
  setUrl("")
}
  const drawer = (
    <div>
      <Link to="/main" style={{ fontSize: 18, textAlign: 'center', display: 'block', marginTop: 20 }}>
        На главную
      </Link>
      <Divider style={{marginTop: 20}}/>
      <List>
        <ListItem button key={"Загрузить базу"} onClick={setBaseUrl}>
          <ListItemIcon>
            <IconButton
              color="primary"
              aria-label="upload picture"
              component="span"
            >
              <LocalAirportRoundedIcon/>
            </IconButton>
          </ListItemIcon >
          <ListItemText primary="Загрузить базу" />
        </ListItem>

        <ListItem button key={"Загрузить пользователей"} onClick ={setUserUrl}>
          <ListItemIcon>
            <IconButton
              color="primary"
              aria-label="upload picture"
              component="span"
            >
              <PersonAddIcon />
            </IconButton>
          </ListItemIcon>
          <ListItemText primary={"Загрузить пользователей"}/>
        </ListItem>
        <ListItem button key={"Назначить старших операторов"} onClick ={setOperator}>
          <ListItemIcon>
            <IconButton
              color="primary"
              aria-label="upload picture"
              component="span"
            >
              <PeopleAltIcon />
            </IconButton>
          </ListItemIcon>
          <ListItemText primary={"Назначить старших операторов"} />
        </ListItem>
      </List>
      <Divider />
      <List>
        <ListItem button key={"Выгрузить отчет"}>
          <ListItemIcon>
            <IconButton
              color="primary"
              aria-label="upload picture"
              component="span"
            >
              <WorkOutlineIcon />
            </IconButton>
          </ListItemIcon>
          <ListItemText primary={"Выгрузить отчет"} />
        </ListItem>
        <ListItem button key={"Графики звонков"}>
          <ListItemIcon>
            <IconButton
              color="primary"
              aria-label="upload picture"
              component="span"
            >
              <ShowChartIcon />
            </IconButton>
          </ListItemIcon>
          <ListItemText primary={"Графики звонков"} />
        </ListItem>
      </List>
    </div>
  );
  
  return (
    <div className={classes.root}>
      <CssBaseline />
      <AppBar position="fixed" className={classes.appBar}>
        <Toolbar>
          <IconButton
            color="inherit"
            aria-label="open drawer"
            edge="start"
            onClick={handleDrawerToggle}
            className={classes.menuButton}
          >
            <MenuIcon />
          </IconButton>
          <Typography variant="h6" noWrap>
            {text ? `Загрузить ${text}` : 'Панель управления'}
            {oper ? "" : null}
          </Typography>
        </Toolbar>
      </AppBar>
      <nav className={classes.drawer} aria-label="mailbox folders">
        {/* The implementation can be swapped with js to avoid SEO duplication of links. */}
        <Hidden smUp implementation="css">
          <Drawer
            container={container}
            variant="temporary"
            anchor={theme.direction === "rtl" ? "right" : "left"}
            open={mobileOpen}
            onClose={handleDrawerToggle}
            classes={{
              paper: classes.drawerPaper,
            }}
            ModalProps={{
              keepMounted: true, // Better open performance on mobile.
            }}
          >
            {drawer}
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
            {drawer}
          </Drawer>
        </Hidden>
      </nav>
      <main className={classes.content}>
        <div className={classes.toolbar} />
        { 
          url ? <UploadFileComponent url ={url} /> : null
        }
        {
          oper ? <ListOperators/> : null
        }
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
  );
}
