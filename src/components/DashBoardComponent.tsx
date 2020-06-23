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
} from "@material-ui/core/styles"
import PersonAddIcon from "@material-ui/icons/PersonAdd"
import { Link } from "react-router-dom"
import LocalAirportRoundedIcon from "@material-ui/icons/LocalAirportRounded"
import PeopleAltIcon from "@material-ui/icons/PeopleAlt"
import WorkOutlineIcon from "@material-ui/icons/WorkOutline"
import ShowChartIcon from "@material-ui/icons/ShowChart"
import ListOperators from "./ListOperatorsComponent"
import UploadFileComponent from "./UploadFileComponent"
import LoaderComponent from "./LoaderComponent"
import { Button } from "@material-ui/core";
import { Grid } from "@material-ui/core"
import DefaultNotice from './NoticeComponent';

const drawerWidth = 240

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
  container?: Element;
}

export function DashBoardComponent(props: DashBoardComponentProps) {
  const { container } = props
  const classes = useStyles()
  const theme = useTheme()
  const [mobileOpen, setMobileOpen] = React.useState(false)
  const handleDrawerToggle = () => {
    setMobileOpen(!mobileOpen)
  }
  
  const [url, setUrl] = React.useState("")
  const [text, setText] = React.useState("")
  const [oper, setOper] = React.useState(false)
  const [loader, setLoader] = React.useState(false)
  const [report, setReport] = React.useState(false)
  const [notice, setNotice] = React.useState(false)

  const setBaseUrl = () => {
    setUrl("base")
    setText("базу")
    setOper(false)
    setLoader(false)
    setReport(false)
    setNotice(false)
  }
  const setUserUrl = () => {
    console.log("operator loaded")
    setLoader(false)
    setUrl("user")
    setText("пользователей")
    setOper(false)
    setReport(false)
    setNotice(false)
  }

  const setOperator = () => {
    setLoader(false)
    setReport(false)
    console.log("назначить старших")
    setOper(true)
    setText("операторов")
    setUrl("")
    setNotice(false)
  }
  const getReport = () => {
    setOper(false)
    setUrl("")
    setLoader(true)
    setText("отчет")
      try {
        fetch("http://localhost/komus_new/api/report")
          .then((response) => {
            setNotice(true)
          })
          .then((data) => {
            setLoader(false)
            setReport(true)
          })
      } catch (err) {
        console.log("Ошибка при формировании отчета " + err)
      }
    }

  const drawer = (
    <div>
      <Link
        to="/main"
        style={{
          fontSize: 18,
          textAlign: "center",
          display: "block",
          marginTop: 20,
        }}
      >
        На главную
      </Link>
      <Divider style={{ marginTop: 20 }} />
      <List>
        <ListItem button key={"Загрузить базу"} onClick={setBaseUrl}>
          <ListItemIcon>
            <IconButton
              color="primary"
              aria-label="upload picture"
              component="span"
            >
              <LocalAirportRoundedIcon />
            </IconButton>
          </ListItemIcon>
          <ListItemText primary="Загрузить базу" />
        </ListItem>

        <ListItem button key={"Загрузить пользователей"} onClick={setUserUrl}>
          <ListItemIcon>
            <IconButton
              color="primary"
              aria-label="upload picture"
              component="span"
            >
              <PersonAddIcon />
            </IconButton>
          </ListItemIcon>
          <ListItemText primary={"Загрузить пользователей"} />
        </ListItem>
        <ListItem
          button
          key={"Назначить старших операторов"}
          onClick={setOperator}
        >
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
        <ListItem button key={"Выгрузить отчет"} onClick={getReport}>
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
          <Typography
            variant="h6"
            noWrap
            style={{ paddingLeft: -30, margin: "auto", paddingRight: 44 }}
          >
            {text ? `Загрузить ${text}` : "Панель управления"}
            {oper ? "" : null}
          </Typography>
        </Toolbar>
      </AppBar>
      <nav className={classes.drawer} aria-label="mailbox folders">
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
              keepMounted: true,
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
        {url ? <Grid item xs={12} lg={3} sm={4} md={4} style={{ marginBottom: 20 }}>
              <UploadFileComponent url={url} /> 
            </Grid>
        : null }
        {oper ? <ListOperators /> : null}
        {loader ? (
          <Grid item xs={12} lg={2} sm={4} md={4} style={{ marginBottom: 20 }}>
            <div style={{ marginLeft: "130px" }}>
              <LoaderComponent />
            </div>
            <div style={{ fontSize: "18px", marginTop: "-10px" }}>
              Отчет формируется
            </div>
          </Grid>
        ) : null}
        {report ? (
          <Grid item xs={12} lg={3} sm={4} md={4} style={{ marginBottom: 20 }}>
            <Button
              href="http://localhost/komus_new/report.xlsx"
              variant="outlined"
              color="primary"
              style={{ width: '100%', margin: 'auto', height: 55, marginTop: 5 }}
            >
              Скачать отчет
            </Button>
            
          </Grid>
        ) : null}
        {
          notice ? <DefaultNotice/> : null
        }
      </main>
    </div>
  )
}
