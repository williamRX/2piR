import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App.tsx'
import { CssBaseline } from '@mui/material'
import { createTheme, ThemeProvider } from '@mui/material/styles'
import { lightGreen, green, grey } from '@mui/material/colors'
import { ApiProvider } from './Provider/ApiProvider.tsx'

const theme = createTheme({
  palette: {
    primary: {
      main: lightGreen[700],
    },
    secondary: {
      main: green[200],
    },
    text: {
      primary: grey[900],
      secondary: lightGreen[700],
    },
  },
  typography: {
    fontFamily: 'Merriweather, serif',
  },
});

ReactDOM.createRoot(document.getElementById('root')!).render(
  <React.StrictMode>
    <CssBaseline />
    <ThemeProvider theme={theme}>
      <ApiProvider>
        <App />
      </ApiProvider>
    </ThemeProvider>
  </React.StrictMode>,
)
