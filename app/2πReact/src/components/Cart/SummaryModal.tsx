import { Dialog, DialogTitle, DialogContent, DialogActions, Button, List, ListItem, Typography } from '@mui/material';
import { useApi } from '../../Provider/ApiProvider';
import { useEffect, useState } from 'react';
import { Order } from '../../type';

interface SummaryModalProps {
    open: boolean;
    handleClose: () => void;
    cart: any[];
    orderInfo: any;
}

function SummaryModal({ open, handleClose, cart, orderInfo }: SummaryModalProps) {

    const api = useApi();
    const { getOrder, validateOrder } = api;
    const [order, setOrder] = useState<Order | null>(null);

    useEffect(() => {
        if (open) {
            const fetchOrder = async () => {
                try {
                    const orders = await getOrder();
                    if (orders.length > 0) {
                        const orderWithHighestId = orders.sort((a: Order, b: Order) => b.id - a.id)[0];
                        setOrder(orderWithHighestId);
                    }
                } catch (error) {
                    console.error('Failed to fetch order:', error);
                }
            };
            fetchOrder();
        }
    }, [open]);


    const handleValidateOrder = async () => {
        if (order) {
            try {
                await validateOrder(order.id);
                localStorage.removeItem('cart');
                handleClose();
                window.location.reload();
            } catch (error) {
                console.error('Failed to validate order:', error);
            }
        }
    };

    return (
        <Dialog open={open} onClose={handleClose}>
            <DialogTitle>Récapitulatif de la commande</DialogTitle>
            <DialogContent>
                <Typography variant="h6">Produits :</Typography>
                <List>
                    {cart.map((product) => (
                        <ListItem key={product.id}>
                            {product.name} - {product.price}€
                        </ListItem>
                    ))}
                </List>
                {orderInfo && (
                    <>
                        <Typography variant="h6">Total : {orderInfo.total_price}€</Typography>
                        <Typography variant="h6">Informations personnelles :</Typography>
                        <Typography>Adresse : {orderInfo.shipping_address}</Typography>
                        <Typography>Ville : {orderInfo.shipping_city}</Typography>
                        <Typography>Région : {orderInfo.shipping_state}</Typography>
                        <Typography>Code postal : {orderInfo.shipping_postal_code}</Typography>
                        <Typography>Pays : {orderInfo.shipping_country}</Typography>
                    </>
                )}
            </DialogContent>
            <DialogActions>
                <Button onClick={handleValidateOrder} variant="contained">Valider la commande</Button>
            </DialogActions>
        </Dialog>
    );
}

export default SummaryModal;