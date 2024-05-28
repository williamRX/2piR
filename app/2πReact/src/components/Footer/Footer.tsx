import React from 'react';
import { Hidden, Box, Divider } from '@mui/material';
import InstagramIcon from '@mui/icons-material/Instagram';
import { GitHub, X } from '@mui/icons-material';

const Footer = () => {
    return (
        <footer style={{ backgroundColor: '#f5f5f5', padding: '10px 0', width: '80vw', margin: '0 auto' }}>
            <Box display="flex" flexDirection='column' >
                <Divider />
                <Box display="flex">
                    <div style={{ display: 'flex', flexDirection: 'column' }}>
                        <h3>Contactez-nous</h3>
                        <p>Email: deuxpir@pierre.com</p>
                    </div>
                    <Box display='flex' justifyContent='space-between' sx={{ width: { xs: '50%', lg: '25%', xl: "25%" }, margin: '0 auto', alignItems: 'center' }}>
                        <X />
                        <GitHub />
                        <InstagramIcon />
                    </Box>
                </Box>
            </Box>
        </footer>
    );
};

export default Footer;