import { Dialog, DialogTitle, DialogContent, DialogActions, Button, TextField, Box } from '@mui/material';
import { useApi } from '../../Provider/ApiProvider';
import { useEffect, useState } from 'react';
import { CustomerResponse } from '../../type';


interface ModalPaymentProps {
    open: boolean;
    handleClose: () => void;
    orderId: string;
}

export default function ModalPayment({ open, handleClose, orderId }: ModalPaymentProps) {

    const api = useApi();
    const { createCustomer, validatePayment } = api;
    const [customerId, setCustomerId] = useState('');

    useEffect(() => {
        if (open) {
            createCustomer().then((response: CustomerResponse) => {
                setCustomerId(response.customerId);
            });
        }
    }, [open]);

    const handleValidatePayment = async () => {
        try {
            const orderIdNumber = parseInt(orderId, 10);
            await validatePayment(orderIdNumber, customerId);
            handleClose();
            window.location.reload();
        } catch (error) {
            console.error(error);
        }
    };


    return (
        <Dialog open={open} onClose={handleClose}>
            <DialogTitle>Informations de paiement</DialogTitle>
            <DialogContent>
                <Box
                    component="form"
                    sx={{
                        '& .MuiTextField-root': { m: 1, width: '25ch' },
                    }}
                    noValidate
                    autoComplete="off"
                >
                    <div>
                        <TextField
                            autoFocus
                            id="outlined-basic"
                            label="Nom"
                            variant="outlined"
                        />
                        <TextField
                            id="outlined-basic"
                            label="Numéro de la carte"
                            variant="outlined"
                            inputProps={{ maxLength: 16 }}
                            onKeyDown={(event) => {
                                if (!/[0-9]/.test(event.key) && event.key !== 'Backspace' && event.key !== 'Delete') {
                                    event.preventDefault();
                                }
                            }}
                        />
                    </div>
                    <div>
                        <TextField
                            id="outlined-basic"
                            label="Date d'expiration (MM/YY)"
                            variant="outlined"
                            onKeyDown={(event) => {
                                if (!/[0-9]/.test(event.key) && event.key !== 'Backspace' && event.key !== 'Delete' && event.key !== '/') {
                                    event.preventDefault();
                                }
                            }}
                        />
                        <TextField
                            id="outlined-basic"
                            label="CVV"
                            variant="outlined"
                            inputProps={{ maxLength: 3 }}
                            onKeyDown={(event) => {
                                if (!/[0-9]/.test(event.key) && event.key !== 'Backspace' && event.key !== 'Delete') {
                                    event.preventDefault();
                                }
                            }}
                        />
                    </div>
                </Box>
            </DialogContent>
            <DialogActions>
                <Button onClick={handleClose} color="primary">
                    Annuler
                </Button>
                <Button onClick={handleValidatePayment} color="primary">
                    Valider le paiement
                </Button>
            </DialogActions>
        </Dialog>
    )
}