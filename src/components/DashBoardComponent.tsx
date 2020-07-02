import React from "react"
import { AppBar, CssBaseline, Divider,
        Drawer, Hidden, IconButton, List,
        ListItem, ListItemIcon, ListItemText,
        Toolbar, Typography, Button, Grid
} from "@material-ui/core"

import {
  makeStyles, useTheme, Theme, createStyles,
} from "@material-ui/core/styles"

import MenuIcon from "@material-ui/icons/Menu"
import PersonAddIcon from "@material-ui/icons/PersonAdd"
import LocalAirportRoundedIcon from "@material-ui/icons/LocalAirportRounded"
import PeopleAltIcon from "@material-ui/icons/PeopleAlt"
import WorkOutlineIcon from "@material-ui/icons/WorkOutline"
import ShowChartIcon from "@material-ui/icons/ShowChart"

import { Link } from "react-router-dom"

import ListOperators from "./ListOperatorsComponent"
import UploadFileComponent from "./UploadFileComponent"
import SpinnerComponent from "./SpinnerComponent"
import DefaultNotice from "./NoticeComponent"

import { ajaxAction } from '../services/index'

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
)

interface DashBoardComponentProps {
  container?: Element
}

export function DashBoardComponent(props: DashBoardComponentProps) {
  const { container } = props
  const classes = useStyles()
  const theme = useTheme()
  const [mobileOpen, setMobileOpen] = React.useState(false)
  const handleDrawerToggle = () => {
    setMobileOpen(!mobileOpen)
  }

  const [apiUrl, setApiUrl] = React.useState("")
  const [titleText, setTitleText] = React.useState("")
  const [operatorBlock, setOperatorBlock] = React.useState(false)
  const [spinner, setSpinner] = React.useState(false)
  const [reportBlock, setReportBlock] = React.useState(false)
  const [noticeModal, setNoticeModal] = React.useState(false)
  const [users, setUsers] = React.useState("")

  const setBaseUrl = () => {
    setApiUrl("base")
    setTitleText("Загрузить базу")
    setOperatorBlock(false)
    setSpinner(false)
    setReportBlock(false)
    setNoticeModal(false)
  };
  const setUserUrl = () => {
    console.log("operator loaded")
    setSpinner(false)
    setApiUrl("user")
    setTitleText("Загрузить пользователей")
    setOperatorBlock(false)
    setReportBlock(false)
    setNoticeModal(false)
  };

  const getReport = async () => {
    setOperatorBlock( false )
    setApiUrl( "" )
    setSpinner( true )
    setTitleText( "Выгрузка отчета" )
    // const url : string = 'report'
    // const method : string = 'GET'
    // const resp = await ajaxAction( url, method )
    // setSpinner( false )
    // setReportBlock( true )
    try {
      fetch("http://localhost/komus_new/api/report")
        .then(( response ) => {
          setNoticeModal( true )
        })
        .then(( data ) => {
          setSpinner( false )
          setReportBlock( true )
        });
    } catch ( err ) {
      console.log( "Ошибка при формировании отчета " + err )
    }
  }
    const getUsers = async () => {
    const url : string = 'user'
    const method : string = 'GET'
    const resp = await ajaxAction( url, method )
    setUsers( resp )
    setSpinner( false )
    setReportBlock( false )
    console.log( "назначить старших" )
    setOperatorBlock( true )
    setTitleText( "Назначить старшего оператора" )
    setApiUrl( "" )
    setNoticeModal( false )
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
        <ListItem button key={"Загрузить базу"} onClick={ setBaseUrl }>
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

        <ListItem button key={"Загрузить пользователей"} onClick={ setUserUrl }>
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
          onClick={ getUsers }
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
  )

  return (
    <div className={ classes.root }>
      <CssBaseline />
      <AppBar position="fixed" className={ classes.appBar }>
        <Toolbar>
          <IconButton
            color="inherit"
            aria-label="open drawer"
            edge="start"
            onClick={ handleDrawerToggle }
            className={ classes.menuButton }
          >
            <MenuIcon />
          </IconButton>
          <Typography
            variant="h6"
            noWrap
            style={{ paddingLeft: -30, margin: "auto", paddingRight: 44 }}
          >
            { titleText ? `${titleText}` : "Панель управления" }
            { operatorBlock ? "" : null }
          </Typography>
        </Toolbar>
      </AppBar>
      <nav className={classes.drawer} aria-label="mailbox folders">
        <Hidden smUp implementation="css">
          <Drawer
            container={container}
            variant="temporary"
            anchor={ theme.direction === "rtl" ? "right" : "left" }
            open={ mobileOpen }
            onClose={ handleDrawerToggle }
            classes={{ paper: classes.drawerPaper }}
            ModalProps={{ keepMounted: true }}
          >
            { drawer }
          </Drawer>
        </Hidden>
        <Hidden xsDown implementation="css">
          <Drawer
            classes={{ paper: classes.drawerPaper }}
            variant="permanent"
            open
          >
            { drawer }
          </Drawer>
        </Hidden>
      </nav>
      <main className={ classes.content }>
        <div className={ classes.toolbar } />
        { apiUrl ? (
          <Grid item xs={12} lg={3} sm={4} md={4} style={{ marginBottom: 20 }}>
            <UploadFileComponent url={apiUrl} />
          </Grid>
        ) : null }
        { operatorBlock ? <ListOperators users= { users }/> : null}
        { spinner ? (
          <Grid item xs={12} lg={2} sm={4} md={4} style={{ marginBottom: 20 }}>
            <div style={{ marginLeft: "130px" }}>
              <SpinnerComponent />
            </div>
            <div style={{ fontSize: "18px", marginTop: "-10px" }}>
              Отчет формируется
            </div>
          </Grid>
        ) : null }
        { reportBlock ? (
          <Grid item xs={12} lg={3} sm={4} md={4} style={{ marginBottom: 20 }}>
            <Button
              href="http://localhost/komus_new/report.xlsx"
              variant="outlined"
              color="primary"
              style={{
                width: "100%",
                margin: "auto",
                height: 55,
                marginTop: 5,
              }}
            >
              Скачать отчет
            </Button>
          </Grid>
        ) : null }
        { noticeModal ? <DefaultNotice /> : null }
      </main>
    </div>
  )
}
