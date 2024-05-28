import React from 'react';
import { Box, Drawer, List, ListItemButton, ListItemText, IconButton } from '@mui/material';
import { Link } from 'react-router-dom';
import CloseIcon from '@mui/icons-material/Close';

interface DrawerToolProps {
  drawerOpen: boolean;
  handleDrawerClose: () => void;
}

const DrawerTool: React.FC<DrawerToolProps> = ({ drawerOpen, handleDrawerClose }) => {

  const categories = [
    { id: 1, name: "Les Pierres" },
    { id: 3, name: "Les Pierres précieuses" },
    { id: 2, name: "Les Menhir" },
  ];

  return (
    
    <Drawer open={drawerOpen} onClose={handleDrawerClose} >
      <Box
        sx={{
          width: {
            xs: '200px',
            sm: '300px',
            md: '350px',
          },
        }}
      >
        <IconButton onClick={handleDrawerClose} >
          <CloseIcon fontSize='large'
            sx={{
              position: 'absolute',
              top: 0,
              left: {
                xs: '150px',
                sm: '250px',
                md: '300px',
              },
            }}
          />
        </IconButton>
        <List sx={{ m: 3 }}>
          <ListItemText
            primary="Les catégories"
            primaryTypographyProps={{ fontWeight: 'bold', fontSize: '1.5rem', marginTop: 2 }}
          />
          {categories.map((category) => (
            <Link to={`/categorie/${category.id}`} style={{ textDecoration: 'none', color:"#689f38" }} key={category.id}>
              <ListItemButton onClick={handleDrawerClose}>
                <ListItemText primary={category.name}/>
              </ListItemButton>
            </Link>
          ))}
        </List>
      </Box>
    </Drawer >
  );
};

export default DrawerTool;
