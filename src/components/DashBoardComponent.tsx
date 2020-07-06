import React from "react"
import { AppBar, CssBaseline, Divider,
        Drawer, Hidden, IconButton, List,
        ListItem, ListItemIcon, ListItemText,
        Toolbar, Typography, Button, Grid
} from "@material-ui/core"

import {
  makeStyles, useTheme, Theme, createStyles,
} from "@material-ui/core/styles"

import * as i from '@material-ui/icons'

import { Link } from "react-router-dom"

import ListOperators from "./ListOperatorsComponent"
import UploadFileComponent from "./UploadFileComponent"
import SpinnerComponent from "./SpinnerComponent"
import DefaultNotice from "./NoticeComponent"

import { ajaxAction } from '../services/index'

const drawerWidth = 240

const useStyles = makeStyles(( theme: Theme ) =>
  createStyles({
    root: {
      display: "flex",
    },
    drawer: {
      [theme.breakpoints.up( "sm" )]: {
        width: drawerWidth,
        flexShrink: 0,
      },
    },
    appBar: {
      [theme.breakpoints.up( "sm" )]: {
        width: `calc(100% - ${drawerWidth}px)`,
        marginLeft: drawerWidth,
      },
    },
    menuButton: {
      marginRight: theme.spacing( 2 ),
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
      padding: theme.spacing( 3 ),
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
  const [mobileOpen, setMobileOpen] = React.useState( false )
  const handleDrawerToggle = () => {
    setMobileOpen( !mobileOpen )
  }
  
  const [titleText, setTitleText] = React.useState( "" )
  const [users, setUsers] = React.useState( "" )
  
  const [operatorDiv, setVisibleOperatorDiv] = React.useState( false )
  const [spinnerDiv, setVisibleSpinnerDiv] = React.useState( false )
  const [reportDiv, setVisibleReportDiv] = React.useState( false )
  /*  
      !  uploadDiv используется два раза: 
      1. для загрузки пользователей из файла
      2. для загрузки базы контактов из файла
  */
  const [uploadDiv, setVisibleUploadDiv] = React.useState( "" )
  const [noticeModal, setVisibleNoticeModal] = React.useState( false )
  
  const setUploadBase = () => {
    setTitleText( "Загрузить базу" )
    setVisibleUploadDiv( "base" )
    setVisibleOperatorDiv( false )
    setVisibleSpinnerDiv( false )
    setVisibleReportDiv( false )
    setVisibleNoticeModal( false )
  }

  const setUploadUser = () => {
    setTitleText( "Загрузить пользователей" )
    setVisibleUploadDiv( "user" )
    setVisibleOperatorDiv( false )
    setVisibleSpinnerDiv( false )
    setVisibleReportDiv( false )
    setVisibleNoticeModal( false )
  }

  const getReport = async () => {
    setTitleText( "Выгрузка отчета" )
    setVisibleSpinnerDiv( true )
    setVisibleOperatorDiv( false )
    setVisibleUploadDiv( "" )
    // const url : string = 'report'
    // const method : string = 'GET'
    // const resp = await ajaxAction( url, method )
    // setSpinner( false )
    // setReportBlock( true )
    try {
      fetch("http://localhost/komus_new/api/report")
        .then(( response ) => {
          setVisibleNoticeModal( true )
        })
        .then(( data ) => {
          setVisibleSpinnerDiv( false )
          setVisibleReportDiv( true )
        });
    } catch ( err ) {
      console.log( "Ошибка при формировании отчета " + err )
    }
  }
    const getUsers = async () => {

    setTitleText( "Назначить старшего оператора" )
    setVisibleOperatorDiv( true )
    const url : string = 'user'
    const method : string = 'GET'
    const operators = await ajaxAction( url, method )
    setUsers( operators )
    setVisibleSpinnerDiv( false )
    setVisibleReportDiv( false )
    setVisibleUploadDiv( "" )
    setVisibleNoticeModal( false )
  }
  const drawer = (
    <div>
      <Link
        to = "/main"
        style = {{
          fontSize: 18,
          textAlign: "center",
          display: "block",
          marginTop: 20,
        }}
      >
        На главную
      </Link>
      <Divider style = {{ marginTop: 20 }} />
      <List>
        <ListItem button key = { "Загрузить базу" } onClick = { setUploadBase }>
          <ListItemIcon>
            <IconButton
              color = "primary"
              aria-label = "upload picture"
              component = "span"
            >
              <i.LocalAirportRounded />
            </IconButton>
          </ListItemIcon>
          <ListItemText primary = "Загрузить базу" />
        </ListItem>

        <ListItem button key = { "Загрузить пользователей" } onClick={ setUploadUser }>
          <ListItemIcon>
            <IconButton
              color="primary"
              aria-label = "upload picture"
              component = "span"
            >
              <i.PersonAdd/>
            </IconButton>
          </ListItemIcon>
          <ListItemText primary = { "Загрузить пользователей" } />
        </ListItem>
        <ListItem
          button
          key = { "Назначить старших операторов" }
          onClick = { getUsers }
        >
          <ListItemIcon>
            <IconButton
              color = "primary"
              aria-label = "upload picture"
              component = "span"
            >
              <i.PeopleAlt />
            </IconButton>
          </ListItemIcon>
          <ListItemText primary = { "Назначить старших операторов" } />
        </ListItem>
      </List>
      <Divider />
      <List>
        <ListItem button key = { "Выгрузить отчет" } onClick = { getReport }>
          <ListItemIcon>
            <IconButton
              color = "primary"
              aria-label = "upload picture"
              component = "span"
            >
              <i.WorkOutline />
            </IconButton>
          </ListItemIcon>
          <ListItemText primary = { "Выгрузить отчет" } />
        </ListItem>
        <ListItem button key = { "Графики звонков" }>
          <ListItemIcon>
            <IconButton
              color = "primary"
              aria-label = "upload picture"
              component = "span"
            >
              <i.ShowChart />
            </IconButton>
          </ListItemIcon>
          <ListItemText primary = { "Графики звонков" } />
        </ListItem>
      </List>
    </div>
  )

  return (
    <div className = { classes.root }>
      <CssBaseline />
      <AppBar position = "fixed" className = { classes.appBar }>
        <Toolbar>
          <IconButton
            color = "inherit"
            aria-label = "open drawer"
            edge = "start"
            onClick = { handleDrawerToggle }
            className = { classes.menuButton }
          >
            <i.Menu />
          </IconButton>
          <Typography
            variant = "h6"
            noWrap
            style = {{ paddingLeft: -30, margin: "auto", paddingRight: 44 }}
          >
            { titleText ? `${titleText}` : "Панель управления" }
          </Typography>
        </Toolbar>
      </AppBar>
      <nav className = { classes.drawer } aria-label="mailbox folders">
        <Hidden smUp implementation="css">
          <Drawer
            container = { container }
            variant = "temporary"
            anchor = { theme.direction === "rtl" ? "right" : "left" }
            open = { mobileOpen }
            onClose = { handleDrawerToggle }
            classes = {{ paper: classes.drawerPaper }}
            ModalProps = {{ keepMounted: true }}
          >
            { drawer }
          </Drawer>
        </Hidden>
        <Hidden xsDown implementation="css">
          <Drawer
            classes = {{ paper: classes.drawerPaper }}
            variant = "permanent"
            open
          >
            { drawer }
          </Drawer>
        </Hidden>
      </nav>
      <main className = { classes.content }>
        <div className = { classes.toolbar } />
        { uploadDiv ? (
          <Grid item xs = { 12 } lg = { 3 } sm = { 4 } md = { 4 } style={{ marginBottom: 20 }}>
            <UploadFileComponent url={ uploadDiv } />
          </Grid>
        ) : null }
        { operatorDiv ? <ListOperators users= { users }/> : null }
        { spinnerDiv ? (
          <Grid item xs = { 12 } lg = { 2 } sm = { 4 } md = { 4 } style={{ marginBottom: 20 }}>
            <div style = {{ marginLeft: "130px" }}>
              <SpinnerComponent />
            </div>
            <div style = {{ fontSize: "18px", marginTop: "-10px" }}>
              Отчет формируется
            </div>
          </Grid>
        ) : null }
        { reportDiv ? (
          <Grid item xs = { 12 } lg = { 3 } sm = { 4 } md = { 4 } style={{ marginBottom: 20 }}>
            <Button
              href = "http://localhost/komus_new/report.xlsx"
              variant = "outlined"
              color = "primary"
              style = {{
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
