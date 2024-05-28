import { useParams } from 'react-router-dom';
import { useApi } from '../../Provider/ApiProvider';
import { useEffect, useState } from 'react';
import { Grid, Button, Box, ButtonBase } from '@mui/material';
import Title from '../tools/Typography/Title';
import Body from '../tools/Typography/Body';
import { useMediaQuery } from '@mui/material';
import { useTheme } from '@mui/material/styles';
import { Product as ProductType } from '../../type';
import { useNavigate } from 'react-router-dom';

interface ProductProps {
    setOpenCartSnackbar: (value: boolean) => void;
}

export default function Product({setOpenCartSnackbar} : ProductProps) {

    const [productById, setProductById] = useState<ProductType | null>(null);
    const { id } = useParams<{ id: string }>();
    const api = useApi();
    const { getProductById, addToCart } = api;
    const [count, setCount] = useState<number>(0);
    const navigate = useNavigate();    

    const theme = useTheme();
    const matchesXL = useMediaQuery(theme.breakpoints.up('xl'));
    const matchesLG = useMediaQuery(theme.breakpoints.between('lg', 'xl'));
    const matchesMD = useMediaQuery(theme.breakpoints.between('md', 'lg'));
    const matchesSM = useMediaQuery(theme.breakpoints.between('sm', 'md'));
    const matchesXS = useMediaQuery(theme.breakpoints.down('sm'));

    let imageSize;
    if (matchesXL) {
        imageSize = 400;
    } else if (matchesLG) {
        imageSize = 350;
    } else if (matchesMD) {
        imageSize = 300;
    } else if (matchesSM) {
        imageSize = 250;
    } else if (matchesXS) {
        imageSize = 200;
    }

    const handleAddToCart = async () => {
        if (count === 0 || !productById) return;
        try {
            const productToAdd = {
                ...productById,
                quantity: count
            };
            await addToCart(productToAdd);
            setOpenCartSnackbar(true);
            navigate('/cart');
        } catch (error) {
            alert('Failed to add product to cart');
        }
    };

    useEffect(() => {
        const fetchProduct = async () => {
            const product = await getProductById(Number(id));
            setProductById(product);
        };

        fetchProduct();
    }, [id, getProductById]);

    return (
        <div style={{ height: "80vh", display: 'flex', alignItems: 'center', margin: '0 auto' }}>
            {productById && (
                <Grid container sx={{ display: 'flex' }}>
                    <Grid item xs={12} sm={6} sx={{ display: 'flex', justifyContent: matchesXS ? 'center' : 'flex-end', marginBottom: { xs: 2 } }}>
                        <img
                            src={productById.photo}
                            alt={productById.name}
                            style={{ width: imageSize, height: imageSize, borderRadius: "50%" }} />
                    </Grid>
                    <Grid item xs={12} sm={6} sx={{ display: 'flex', flexDirection: 'column', justifyContent: 'space-between', textAlign: matchesXS ? 'center' : 'inherit' }}>
                        <Title sx={{ fontWeight: 'bold', marginBottom: { xs: 2 } }}>{productById.name}</Title>
                        <Body
                            sx={{ marginBottom: { xs: 2 }, marginLeft: { xs: 0, sm: 2 } }}>{
                                productById.description}
                        </Body>
                        <Body
                            fontWeight={'bold'}
                            sx={{ marginBottom: { xs: 2 } }}
                        >
                            {productById.price} €
                        </Body>
                        <Box
                            sx={{
                                display: 'flex',
                                margin: matchesXS ? '0 auto' : 'inherit'
                            }}
                        >
                            <Box
                                sx={{
                                    display: 'flex',
                                    alignItems: 'center',
                                    border: '2px solid black',
                                    borderRadius: 2
                                }}
                            >
                                <ButtonBase
                                    sx={{
                                        width: 40,
                                        height: 36
                                    }}
                                    onClick={() => {
                                        if (count > 0) {
                                            setCount(count - 1);
                                        }
                                    }}>
                                    <Body>
                                        -
                                    </Body>
                                </ButtonBase>
                                <Body fontSize={"1.5rem"}>{count}</Body>
                                <ButtonBase
                                    sx={{
                                        width: 40,
                                        height: 36
                                    }}
                                    onClick={() => setCount(count + 1)}>
                                    <Body>
                                        +
                                    </Body>
                                </ButtonBase>
                            </Box>
                            <Button
                                variant='contained'
                                color="secondary"
                                sx={{ marginLeft: 2, color: "white" }}
                                onClick={handleAddToCart}
                            >
                                Ajouter au panier
                            </Button>
                        </Box>
                    </Grid>
                </Grid>
            )}
        </div>
    );
}