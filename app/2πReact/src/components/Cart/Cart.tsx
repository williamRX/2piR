import { Card, CardContent, CardMedia, Typography, Button, Box, Grid } from '@mui/material';
import { useState, useEffect } from 'react';
import { Product, ProductOrder } from '../../type';
import { useApi } from "../../Provider/ApiProvider";
import ModalInfo from './ModalInfo';
import SummaryModal from './SummaryModal';
import ModalPayment from './ModalPayment';


const Cart = () => {

    const [openModalInfo, setOpenModalInfo] = useState(false);
    const handleOpen = () => {
        setOpenModalInfo(true);
    };
    const handleClose = () => {
        setOpenModalInfo(false);
    };

    const [openModalSummary, setOpenModalSummary] = useState(false);
    const handleOpenSummary = () => {
        setOpenModalSummary(true);
    };
    const handleCloseSummary = () => {
        setOpenModalSummary(false);
    };

    const [openModalPayment, setOpenModalPayment] = useState(false);
    const [selectedOrderId, setSelectedOrderId] = useState<string | null>(null);
    const handleOpenPayment = (orderId: string) => {
        setSelectedOrderId(orderId);
        setOpenModalPayment(true);
    };
    const handleClosePayment = () => {
        setOpenModalPayment(false);
    };

    const [cart, setCart] = useState<Product[]>([]);
    const [orderInfo, setOrderInfo] = useState(null);
    const [orders, setOrders] = useState([]);
    const api = useApi();

    const { deleteFromCart, getAllOrder } = api;
    const total = cart.reduce((acc, product) => acc + product.price * (product.quantity ?? 0), 0).toFixed(2);

    useEffect(() => {
        const storedCart = localStorage.getItem('cart');
        if (storedCart) {
            setCart(JSON.parse(storedCart));
        }
    }, []);

    const handleDelete = async (product: Product) => {
        try {
            await deleteFromCart(product);
            const storedCart = JSON.parse(localStorage.getItem('cart') || '[]');
            const updatedCart = storedCart.filter((p: Product) => p.id !== product.id);
            localStorage.setItem('cart', JSON.stringify(updatedCart));
            setCart(updatedCart);
        } catch (error) {
            console.error('Failed to delete product from cart', error);
        }
    }

    useEffect(() => {
        const fetchOrders = async () => {
            const allOrders = await getAllOrder();
            const groupedOrders = allOrders.reduce((acc, order) => {
                if (!acc[order.order_id]) {
                    acc[order.order_id] = [order];
                } else {
                    acc[order.order_id].push(order);
                }
                return acc;
            }, {});
            setOrders(Object.values(groupedOrders));
            console.log(orders);
        };

        fetchOrders();
    }, []);

    return (
        <Box sx={{ height: '76vh', marginTop: { xl: 5, md: 3, sm: 2, xs: 2 }, overflowY: 'auto' }}>
            <Grid container spacing={2} sx={{ textAlign: 'center' }}>
                <Grid item md={8} sm={12} xs={12}>
                    {cart.length === 0 ? (
                        <p>Votre panier est vide</p>
                    ) : (
                        cart.map((product, index) => (
                            <Box sx={{ display: 'flex', justifyContent: 'center', marginBottom: 2 }} key={index}>
                                <Card sx={{ display: 'flex', flexDirection: { xs: 'column', sm: 'inherit' }, width: '75%', }}>
                                    <Box sx={{ display: 'flex', justifyContent: 'center', marginTop: { xs: 2, sm: 0 }, margin: { sm: 2 } }}>
                                        <CardMedia
                                            component="img"
                                            sx={{ borderRadius: '50%', width: 150, height: 150 }}
                                            image={product.photo}
                                            alt={product.name}
                                        />
                                    </Box>
                                    <CardContent sx={{ display: 'flex', flexDirection: 'column', justifyContent: 'space-between' }}>
                                        <Typography variant="h6" component="div" fontWeight={'bold'}>
                                            {product.name}
                                        </Typography>
                                        <Typography variant="body2" color="text.secondary" fontWeight={'bold'}>
                                            Quantité : {product.quantity}
                                        </Typography>
                                        <Button variant="contained" color="secondary" sx={{ fontWeight: 'bold', color: "white" }} size='small'
                                            onClick={() => handleDelete(product)}
                                        >
                                            Supprimer du panier
                                        </Button>
                                    </CardContent>
                                </Card>
                            </Box>
                        ))
                    )}
                </Grid>
                <Grid item md={4} sm={12} xs={12}>
                    <Box sx={{ position: "sticky", top: 0 }}>
                        <h2 style={{ margin: 0 }}>Résumé de votre panier</h2>
                        <p style={{ fontWeight: 'bold' }}>Total : {total}€</p>
                        {cart.length > 0 ? (
                            <Button variant="contained" color="secondary" sx={{ fontWeight: 'bold', color: "white" }} onClick={handleOpen}>
                                Commander
                            </Button>
                        ) : null}
                    </Box>

                </Grid>
                <Grid item xs={12} md={8}
                    sx={{ display: 'flex', justifyContent: 'center', marginTop: 2 }}>
                    <h2 style={{ margin: 0 }}>Historique de vos commandes</h2>
                </Grid>
                <Grid item xs={12} md={8}>
                    {orders.length === 0 ? (
                        <p>Vous n'avez pas de commandes</p>
                    ) : (
                        orders.map((group, i) => (
                            <Box key={i} sx={{ display: 'flex', justifyContent: 'center', marginBottom: 2 }}>
                                <Card sx={{ display: 'flex', flexDirection: { xs: 'column', sm: 'column' }, width: '75%', }}>
                                    {group.map((order, j) => (
                                        <Box key={j} sx={{ display: 'flex', justifyContent: 'flex-start', marginTop: { xs: 2, sm: 0 }, margin: { sm: 2 } }}>
                                            <CardMedia
                                                component="img"
                                                sx={{ borderRadius: '50%', width: 100, height: 100, marginLeft: 1 }}
                                                image={order.product_photo}
                                                alt={order.product_name}
                                            />
                                            <CardContent sx={{ display: 'flex', flexDirection: 'column', justifyContent: 'space-between' }}>
                                                <Typography variant="h6" component="div" fontWeight={'bold'}>
                                                    {order.product_name}
                                                </Typography>
                                                <Typography variant="body2" color="text.secondary" fontWeight={'bold'}>
                                                    Quantité : {order.quantity}
                                                </Typography>
                                                <Typography variant="body2" color="text.secondary" fontWeight={'bold'}>
                                                    Prix : {order.product_price}
                                                </Typography>
                                            </CardContent>
                                        </Box>
                                    ))}
                                    <CardContent sx={{ display: 'flex', flexDirection: 'column', justifyContent: 'space-between' }}>
                                        {group[0].payment_status === 'Pending' ? (
                                            <Button variant="contained" color="primary" sx={{ alignSelf: 'flex-end' }} 
                                            onClick={() => handleOpenPayment(group[0].order_id)}
                                            >
                                                Procéder au paiement
                                            </Button>
                                        ) : (
                                            <Typography variant="body2" color="text.secondary" fontWeight={'bold'} sx={{ alignSelf: 'flex-end' }}>
                                                Paiement effectué
                                            </Typography>
                                        )}
                                        <Typography variant="h6" component="div" fontWeight={'bold'}>
                                            Total : {group.reduce((total: number, order: ProductOrder) => total + order.product_price * order.quantity, 0).toFixed(2)} €
                                        </Typography>
                                    </CardContent>
                                </Card>
                            </Box>
                        ))
                    )}
                </Grid>
            </Grid>
            <ModalInfo open={openModalInfo} handleClose={handleClose} total_price={total} setOrderInfo={setOrderInfo} setOpenModalSummary={setOpenModalSummary} />
            <SummaryModal open={openModalSummary} handleClose={handleCloseSummary} orderInfo={orderInfo} cart={cart} />
            <ModalPayment open={openModalPayment} handleClose={handleClosePayment} orderId={selectedOrderId}/>
        </Box>
        

    );
};

export default Cart;