import { useEffect, useState } from 'react';
import { AppBar, Toolbar, IconButton, InputBase, Grid, Box, ButtonBase, Badge } from '@mui/material';
import { Menu as MenuIcon, AccountCircle as AccountCircleIcon, ShoppingCart as ShoppingCartIcon, Home as HomeIcon, Search as SearchIcon, Logout as LogoutIcon } from '@mui/icons-material';
import DrawerTool from '../tools/DrawerTool';
import { Link, useLocation } from 'react-router-dom';
import { Product } from '../../type';


interface NavBarProps {
  setOpenLogoutSnackbar: (value: boolean) => void;
}

function NavBarXS({ setOpenLogoutSnackbar }: NavBarProps) {

  const [drawerOpen, setDrawerOpen] = useState(false);
  const token = localStorage.getItem('token');
  const [totalQuantity, setTotalQuantity] = useState(0);

  const handleDrawerOpen = () => {
    setDrawerOpen(true);
  };

  const handleDrawerClose = () => {
    setDrawerOpen(false);
  };

  const handleLogout = () => {
    localStorage.removeItem('token');
    setOpenLogoutSnackbar(true);
  }

  const location = useLocation();

  useEffect(() => {
    const updateTotalQuantity = () => {
      const storedCart: Product[] = JSON.parse(localStorage.getItem('cart') || '[]');
      const total = storedCart.reduce((total, product: Product) => total + (product.quantity ?? 0), 0);
      setTotalQuantity(total);
    };
    updateTotalQuantity();
    window.addEventListener('cartChanged', updateTotalQuantity);

    return () => {
      window.removeEventListener('cartChanged', updateTotalQuantity);
    };
  }, []);

  return (
    <div>
      <AppBar position="static" >
        <Toolbar sx={{ marginTop: 2, marginBottom: 2 }}>
          <Grid container style={{ alignItems: 'center' }}>
            <Grid item xs={6} >
              <IconButton edge="start" color="inherit" aria-label="menu" onClick={handleDrawerOpen}>
                <MenuIcon fontSize='large' />
              </IconButton>
              <DrawerTool drawerOpen={drawerOpen} handleDrawerClose={handleDrawerClose} />
            </Grid>
            <Grid item xs={6}>
              <Box
                sx={{
                  display: 'flex',
                  justifyContent: 'flex-end',
                }}
              >
                <Link to='/'>
                  {location.pathname !== '/' && (
                    <ButtonBase sx={{ color: 'white', marginRight: 1 }}>
                      <HomeIcon fontSize='large' />
                    </ButtonBase>
                  )}
                </Link>
                <Link to={token ? '/' : '/login'}>
                  <ButtonBase
                    sx={{ color: 'white', }}
                    onClick={token ? handleLogout : undefined}
                  >
                    {token ? <LogoutIcon fontSize='large' /> : <AccountCircleIcon fontSize='large' />}
                  </ButtonBase>
                </Link>
                {token && (
                  <Link to="/cart">
                    <Badge badgeContent={totalQuantity} color="secondary">
                    <ButtonBase sx={{ color: 'white', marginLeft: 1 }}>
                      <ShoppingCartIcon fontSize='large' />
                    </ButtonBase>
                    </Badge>
                  </Link>
                )}
              </Box>
            </Grid>
            <Grid item xs={12} >
              <Box sx={{ borderRadius: 25, backgroundColor: 'whitesmoke', display: 'flex', alignItems: 'center' }}>
                <SearchIcon sx={{ ml: 3, mr: 1 }} color='secondary' />
                <InputBase
                  id="input"
                  placeholder="Rechercher un produit ..."
                />
              </Box>
            </Grid>
          </Grid>
        </Toolbar>
      </AppBar>
    </div>
  );
}

export default NavBarXS;