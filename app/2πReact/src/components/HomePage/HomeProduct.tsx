import { Box, Button, Card, CardActions, CardContent, CardMedia, Grid } from "@mui/material";
import Body from "../tools/Typography/Body";
import Title from "../tools/Typography/Title";
import TitleCard from "../tools/Typography/TitleCard";
import { useApi } from "../../Provider/ApiProvider";
import { useEffect, useState } from "react";
import { Product } from '../../type';
import { Link } from "react-router-dom";


function HomeProduct() {

    const [product, setProduct] = useState<Product | null>(null);
    
    const api = useApi();
    const { getProductById } = api;

    useEffect(() => {
        const fetchProduct = async () => {
            const product = await getProductById(15);
            setProduct(product);
        };

        fetchProduct();
    }, []);

    return (

        <Box sx={{ display: 'flex', flexDirection: 'column', alignItems: 'center', marginTop: 5 }}>
            <Title sx={{ fontWeight: 'bold', textAlign: 'center', marginBottom: 5 }}>Notre produit phare</Title>
            <Box >
                {product && (
                    <Link to={`/product/${product.id}`} style={{ textDecoration: 'none' }}>
                    <Card
                        sx={{
                            maxWidth: 800,
                        }}
                    >
                        <Grid container>
                            <Grid item xs={12} sm={7} md={8}>
                                <CardMedia
                                    component="img"
                                    image={product.photo}
                                    alt={product.name}
                                    sx={{ height: { xs: 300, sm: 400, md: 450, lg: 500, xl: 500 } }}
                                />
                            </Grid>
                            <Grid item xs={12} sm={5} md={4} sx={{ display: 'flex' }}>
                                <CardContent
                                    sx={{
                                        display: "flex",
                                        flexDirection: 'column',
                                        justifyContent: 'space-around',

                                    }}>
                                    <TitleCard sx={{ fontWeight: 'bold' }}>
                                        {product.name}
                                    </TitleCard>
                                    <Body sx={{ marginTop: { xs: 2 }, marginBottom: { xs: 2 } }}>
                                        {product.description}
                                    </Body>
                                    <Body sx={{ marginBottom: { xs: 2 }, fontWeight: 'bold' }} >
                                        {product.price}€
                                    </Body>
                                    <CardActions sx={{ justifyContent: 'flex-end' }}>
                                        <Button size="medium" variant="contained" color="secondary" sx={{ color: 'white' }}>Commander</Button>
                                    </CardActions>
                                </CardContent>
                            </Grid>
                        </Grid>
                    </Card>
                    </Link>
                )}
            </Box>
        </Box>
    )
}

export default HomeProduct