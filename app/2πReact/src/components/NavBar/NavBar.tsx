import { useEffect, useState } from 'react';
import { AppBar, Toolbar, IconButton, InputBase, Button, Grid, Box, useTheme, Badge } from '@mui/material';
import { Menu as MenuIcon, AccountCircle as AccountCircleIcon, ShoppingCart as ShoppingCartIcon, Home as HomeIcon, Search as SearchIcon, Logout as LogoutIcon } from '@mui/icons-material';
import DrawerTool from '../tools/DrawerTool';
import { Link, useLocation } from 'react-router-dom';
import { Product } from '../../type';


interface NavBarProps {
  setOpenLogoutSnackbar: (value: boolean) => void;
}

function NavBar({ setOpenLogoutSnackbar }: NavBarProps) {

  const [drawerOpen, setDrawerOpen] = useState(false);
  const token = localStorage.getItem('token');
  const [totalQuantity, setTotalQuantity] = useState(0);

  const handleDrawerOpen = () => {
    setDrawerOpen(true);
  };

  const handleDrawerClose = () => {
    setDrawerOpen(false);
  };

  const location = useLocation();

  const handleLogout = () => {
    localStorage.removeItem('token');
    setOpenLogoutSnackbar(true);
  };

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
    <Box >
      <AppBar position="static" >
        <Toolbar style={{ marginTop: 15, marginBottom: 15 }}>
          <Grid container style={{ alignItems: 'center' }}>
            <Grid item sm={2} md={2} lg={3} xl={3} style={{ display: "flex", alignItems: 'center' }}>
              <IconButton edge="start" color="inherit" aria-label="menu" onClick={handleDrawerOpen}>
                <MenuIcon fontSize='large' />
              </IconButton>
              <img src="/2PiR.png" alt="logo" style={{ width: 75 }} />
              <DrawerTool drawerOpen={drawerOpen} handleDrawerClose={handleDrawerClose} />
            </Grid>
            <Grid item sm={8} md={8} lg={5} xl={5}>
              <Box sx={{ borderRadius: 25, backgroundColor: 'whitesmoke', display: 'flex', alignItems: 'center', paddingTop: "10px", paddingBottom: "10px" }}>
                <SearchIcon sx={{ ml: 5, mr: 1 }} color='secondary' />
                <InputBase
                  fullWidth
                  id="input"
                  placeholder="Rechercher un produit ..."
                />
              </Box>
            </Grid>
            <Grid item sm={2} md={2} lg={4} xl={4}>
              <Box
                sx={{
                  display: 'flex',
                  justifyContent: 'flex-end',
                  alignItems: 'center',
                }}
              >
                <Link to="/">
                  {location.pathname !== '/' && (
                    <Button sx={{ color: 'white' }}>
                      <HomeIcon fontSize='large'/>
                    </Button>
                  )}
                </Link>
                <Link to={token ? '/' : '/login'}>
                  <Button
                    sx={{
                      minWidth: { sm: '0' },
                      color: 'white',
                      '&:hover': {
                        borderColor: 'white',
                        borderWidth: 2,
                        borderStyle: 'solid',
                      },
                    }}
                    onClick={token ? handleLogout : undefined}
                  >
                    {token ? <LogoutIcon fontSize='large' /> : <AccountCircleIcon fontSize='large' />}
                  </Button>
                </Link>
                {token && (
                  <Link to="/cart">
                    <Button
                      sx={{
                        minWidth: { sm: '0' },
                        color: 'white',
                        '&:hover': {
                          borderColor: 'white',
                          borderWidth: 2,
                          borderStyle: 'solid',
                        },
                      }}
                    >
                      <Badge badgeContent={totalQuantity} color="secondary">
                        <ShoppingCartIcon fontSize='large'/>
                      </Badge>
                    </Button>
                  </Link>
                )}
              </Box>
            </Grid>
          </Grid>
        </Toolbar>
      </AppBar>
    </Box>
  );
}

export default NavBar;