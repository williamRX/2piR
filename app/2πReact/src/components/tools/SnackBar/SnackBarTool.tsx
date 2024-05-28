import React from 'react';
import { Snackbar } from '@mui/material';
import Alert from '@mui/material/Alert';

interface SnackBarToolProps {
    openSnackbar: boolean;
    setOpenSnackbar: (open: boolean) => void;
    openLogoutSnackbar: boolean;
    setOpenLogoutSnackbar: (open: boolean) => void;
    openCartSnackbar: boolean;
    setOpenCartSnackbar: (open: boolean) => void;
}

const SnackBarTool: React.FC<SnackBarToolProps> = ({ openSnackbar, setOpenSnackbar, openLogoutSnackbar, setOpenLogoutSnackbar, openCartSnackbar, setOpenCartSnackbar }) => {
    return (
        <>
            <Snackbar open={openSnackbar} autoHideDuration={5000} onClose={() => setOpenSnackbar(false)} anchorOrigin={{ vertical: 'top', horizontal: 'right' }}>
                <Alert onClose={() => setOpenSnackbar(false)} severity="success" sx={{ width: '100%' }}>
                    Votre compte a bien été créé
                </Alert>
            </Snackbar>
            <Snackbar open={openLogoutSnackbar} autoHideDuration={5000} onClose={() => setOpenLogoutSnackbar(false)} anchorOrigin={{ vertical: 'top', horizontal: 'right' }}>
                <Alert onClose={() => setOpenLogoutSnackbar(false)} severity="info" sx={{ width: '100%' }}>
                    Vous avez été déconnecté
                </Alert>
            </Snackbar>
            <Snackbar
                open={openCartSnackbar}
                autoHideDuration={3000}
                onClose={() => setOpenCartSnackbar(false)}
                anchorOrigin={{ vertical: 'top', horizontal: 'right' }}
                style={{ marginTop: 45 }}
            >
                <Alert onClose={() => setOpenCartSnackbar(false)} severity="success" sx={{ width: '100%' }}>
                    Produit ajouté au panier
                </Alert>
            </Snackbar>
        </>
    );
}

export default SnackBarTool;