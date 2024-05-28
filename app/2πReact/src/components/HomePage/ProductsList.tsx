import { Card, CardContent, Box, IconButton, Grid, Typography, CardActionArea, CardMedia } from "@mui/material";
import Body from "../tools/Typography/Body";
import { useEffect, useRef, useState } from "react";
import ChevronLeftIcon from '@mui/icons-material/ChevronLeft';
import ChevronRightIcon from '@mui/icons-material/ChevronRight';
import TitleCard from "../tools/Typography/TitleCard";
import { useApi } from "../../Provider/ApiProvider";
import { Link } from "react-router-dom";
import { Product } from '../../type';



function ProductsList() {

  const [products, setProducts] = useState<Product[]>([]);
  const api = useApi();
  const { getProducts } = api;

  useEffect(() => {
    const fetchProducts = async () => {
      const allProducts = await getProducts();
      const ids = [1, 2, 3, 11, 13, 14, 21, 23, 25];
      const selectedProducts = allProducts.filter((product: Product) => ids.includes(product.id));
      setProducts(selectedProducts);
    };
    fetchProducts();
  }, []);

  const scrollContainerRef = useRef<HTMLDivElement>(null);

  const scroll = (scrollOffset: any) => {
    scrollContainerRef.current?.scrollBy({
      top: 0,
      left: scrollOffset,
      behavior: 'smooth'
    });
  };

  return (
    <Box >
      <TitleCard sx={{ textAlign: 'center', marginTop: 5, fontWeight: 'bold' }}>Quelques idées</TitleCard>
      <Grid container spacing={2} sx={{ position: 'relative', top: '150px' }}>
        <Grid item xs={6}>
          <IconButton
            aria-label="Scroll Left"
            sx={{ color: 'black', right: "50px" }}
            onClick={() => scroll(-800)}
            size="large">
            <ChevronLeftIcon fontSize="large" />
          </IconButton>
        </Grid>
        <Grid item xs={6} sx={{ display: 'flex', justifyContent: 'flex-end' }}>
          <IconButton
            aria-label="Scroll Right"
            sx={{ color: 'black', left: '50px' }}
            onClick={() => scroll(800)}
            size="large" >
            <ChevronRightIcon fontSize="large" />
          </IconButton>
        </Grid>
      </Grid>
      <Box
        sx={{
          display: 'flex',
          overflowX: 'auto',
          gap: 2,
          '&::-webkit-scrollbar': {
            width: '10px',
            height: '8px',
          },
          '&::-webkit-scrollbar-track': {
            background: '#f1f1f1',
          },
          '&::-webkit-scrollbar-thumb': {
            background: '#888',
            borderRadius: '5px',
            '&:hover': {
              background: '#555',
            },
          },
        }}
        className="products-list-scrollbar"
        ref={scrollContainerRef}>
        {products.map((product) => (
          <Link key={product.id} to={`/product/${product.id}`} style={{ textDecoration: 'none' }}>
            <Card key={product.id} sx={{ width: 300, flexShrink: 0, height: 200 }}>
              <CardActionArea sx={{ display: 'flex', width: 300, height: 200 }}>
                <CardMedia
                  component="img"
                  image={product.photo}
                  alt={product.name}
                  sx={{ width: 180, height: 200 }}
                />
                <CardContent sx={{ display: 'flex', flexDirection: 'column', justifyContent: "space-around", padding: '8px', height: 200 }}>
                  <Body fontWeight={"bold"}>
                    {product.name}
                  </Body>
                  <Typography variant="body2" fontSize={10} >
                    {product.description}
                  </Typography>
                  <Body >
                    {product.price}€
                  </Body>
                </CardContent>
              </CardActionArea>
            </Card>
          </Link>
        ))}
      </Box>
    </Box>
  );
}

export default ProductsList;