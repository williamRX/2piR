import { Box, Card, CardContent, CardMedia, Grid } from "@mui/material";
import Title from "../tools/Typography/Title";
import Body from "../tools/Typography/Body";
import { useApi } from "../../Provider/ApiProvider";
import { useEffect, useState } from "react";
import { Link, useParams } from 'react-router-dom';
import useMediaQuery from '@mui/material/useMediaQuery';
import { useTheme } from '@mui/material/styles';
import { Product } from '../../type';

function Categories() {

    const theme = useTheme();
    const isXs = useMediaQuery(theme.breakpoints.down('xs'));
    const isSm = useMediaQuery(theme.breakpoints.between('sm', 'md'));
    const isMd = useMediaQuery(theme.breakpoints.between('md', 'lg'));
    const isLg = useMediaQuery(theme.breakpoints.between('lg', 'xl'));
    const isXl = useMediaQuery(theme.breakpoints.up('xl'));
    const height = isMd ? 200 : isLg ? 250 : isXl ? 300 : isSm ? 175 : isXs ? 100 : 200;


    const [products, setProducts] = useState<Product[]>([]);
    const [categoryName, setCategoryName] = useState<string>('');


    const { id } = useParams<{ id: string }>();

    const api = useApi();
    const { getProductsByCategory } = api;

    useEffect(() => {
        const fetchProducts = async () => {
            const products = await getProductsByCategory(Number(id));
            setProducts(products);
            setCategoryName(products[0].categorie.nom);
            console.log(categoryName);
        };

        fetchProducts();
    }, [id]);

    return (
        <Box sx={{ width: '80vw', margin: '0 auto', marginTop:{ md:4, sm:3, xs:2}}}>
            <Box sx={{ backgroundColor: '#9ccc65', textAlign: 'center', paddingTop: 2, paddingBottom: 2, borderRadius: 3 }}>
                <Title sx={{ color: "white", fontWeight: 'bold' }}>{categoryName}</Title>

            </Box>
            <Grid container spacing={4} justifyContent={"center"} sx={{ marginTop: 2, marginBottom: 2 }}>
                {products.map((product, index) => (
                    <Grid item xs={12} sm={6} md={6} lg={5} xl={4} key={index}>
                        <Link to={`/product/${product.id}`} style={{ textDecoration: 'none' }}>
                            <Card sx={{ display: "flex", position: "relative" }} >
                                <CardMedia
                                    component="img"
                                    image={product.photo}
                                    alt={product.name}
                                    style={{ height, width: '70%' }}
                                />
                                <CardContent>
                                    <Body sx={{ fontWeight: 'bold', marginBottom: 2 }}>{product.name}</Body>
                                    <Body>{product.price} €</Body>
                                </CardContent>
                            </Card>
                        </Link>
                    </Grid>
                ))}
            </Grid>
        </Box>
    )
}
export default Categories;