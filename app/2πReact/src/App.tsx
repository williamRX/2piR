import NavBar from './components/NavBar/NavBar'
import NavBarXs from './components/NavBar/NavBarXs'
import HomePage from './components/HomePage/HomePage'
import LoginPage from './components/Login/LoginPage';
import RegisterPage from './components/Login/RegisterPage';
import Categories from './components/Product/Categories';
import Product from './components/Product/Product';
import NotFound from './components/Error/404';
import Footer from './components/Footer/Footer';
import Cart from './components/Cart/Cart';
import SnackBarTool from './components/tools/SnackBar/SnackBarTool';
import { useMediaQuery, useTheme } from '@mui/material';
import {
  BrowserRouter,
  Routes,
  Route,
} from "react-router-dom";
import { useState } from 'react';
import ProtectedRoute from './ProtectedRoute';



function App() {

  const theme = useTheme();
  const isLargeScreen = useMediaQuery(theme.breakpoints.up('md'));
  const [openSnackbar, setOpenSnackbar] = useState(false);
  const [openLogoutSnackbar, setOpenLogoutSnackbar] = useState(false);
  const [openCartSnackbar, setOpenCartSnackbar] = useState(false);

  const user = localStorage.getItem('token');

  return (

    <div style={{ backgroundColor: 'whitesmoke' }}>
      <BrowserRouter>
        {isLargeScreen ? <NavBar setOpenLogoutSnackbar={setOpenLogoutSnackbar} /> : <NavBarXs setOpenLogoutSnackbar={setOpenLogoutSnackbar} />}
        <Routes>
          <Route path="/" element={<HomePage />} />
          <Route path="/login" element={<LoginPage />} />
          <Route path="/register" element={<RegisterPage setOpenSnackbar={setOpenSnackbar} />} />
          <Route path="/categorie/:id" element={<Categories />} />
          <Route path="/product/:id" element={<Product setOpenCartSnackbar={setOpenCartSnackbar}/>} />
          <Route path="/cart"
            element={
                <Cart />
            }/>
          <Route path="*" element={<NotFound />} />
        </Routes>
        <Footer />
      </BrowserRouter>

      <SnackBarTool
        openSnackbar={openSnackbar}
        setOpenSnackbar={setOpenSnackbar}
        openLogoutSnackbar={openLogoutSnackbar}
        setOpenLogoutSnackbar={setOpenLogoutSnackbar}
        openCartSnackbar={openCartSnackbar}
        setOpenCartSnackbar={setOpenCartSnackbar}
      />
    </div>
  )
}

export default App
