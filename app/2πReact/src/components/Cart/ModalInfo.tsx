import React, { useState } from 'react';
import { Dialog, DialogTitle, DialogContent, TextField, DialogActions, Button } from '@mui/material';
import { useApi } from "../../Provider/ApiProvider";


interface ModalInfoProps {
    open: boolean;
    handleClose: () => void;
    total_price: number;
    setOrderInfo: (value: any) => void;
    setOpenModalSummary: (value: boolean) => void;
}

const ModalInfo: React.FC<ModalInfoProps> = ({ open, handleClose, total_price, setOrderInfo, setOpenModalSummary}) => {

    const [shipping_address, setAddress] = useState('');
    const [shipping_city, setCity] = useState('');
    const [shipping_state, setRegion] = useState('');
    const [shipping_postal_code, setPostalCode] = useState('');
    const [shipping_country, setCountry] = useState('');

    const api = useApi();
    const { createOrder } = api;

    const handleSubmit = async () => {
        const orderInfo = {
            total_price,
            shipping_address,
            shipping_city,
            shipping_state,
            shipping_postal_code,
            shipping_country,
            payment_method: 'Credit Card',
            payment_status: 'Pending'
        };
        try {
            await createOrder(orderInfo);
            setOrderInfo(orderInfo);
            setOpenModalSummary(true);
            handleClose();
        } catch (error) {
            console.error('Failed to create order', error);
        }
    }

    return (
        <div>
            <Dialog open={open} onClose={handleClose}>
                <DialogTitle>Informations personnelles</DialogTitle>
                <DialogContent>
                    <TextField
                        autoFocus
                        margin="dense"
                        label="Addresse"
                        type="text"
                        fullWidth
                        value={shipping_address}
                        onChange={(e) => setAddress(e.target.value)}
                    />
                    <TextField
                        margin="dense"
                        label="Ville"
                        type="text"
                        fullWidth
                        value={shipping_city}
                        onChange={(e) => setCity(e.target.value)}
                    />
                    <TextField
                        margin="dense"
                        label="Région"
                        type="text"
                        fullWidth
                        value={shipping_state}
                        onChange={(e) => setRegion(e.target.value)}
                    />
                    <TextField
                        margin="dense"
                        label="Code postal"
                        type="text"
                        fullWidth
                        value={shipping_postal_code}
                        onChange={(e) => setPostalCode(e.target.value)}
                    />
                    <TextField
                        margin="dense"
                        label="Pays"
                        type="text"
                        fullWidth
                        value={shipping_country}
                        onChange={(e) => setCountry(e.target.value)}
                    />
                </DialogContent>
                <DialogActions>
                    <Button onClick={handleClose} variant="contained" size='small' sx={{ position: 'absolute', right: '8px', top: '8px' }}>X</Button>
                    <Button onClick={handleSubmit} variant="contained">Valider</Button>
                </DialogActions>
            </Dialog>
        </div>
    );
}

export default ModalInfo;