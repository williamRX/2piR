import { Box, Card, CardMedia, Grid } from "@mui/material";
import TitleCard from "../tools/Typography/TitleCard";
import { Link } from "react-router-dom";

function HomeCategory() {
    return (
        <Box>
            <Box sx={{ display: 'flex', alignItems: 'center', justifyContent: 'center', marginBottom: '-1rem' }}>
                <Box sx={{ height: '4px', width: '3rem', backgroundColor: '#689f38', marginRight: '1rem' }} />
                <TitleCard sx={{ fontWeight: 'bold', textAlign: 'center', marginTop: 5, paddingBottom: 5 }} color="text.secondary">
                    Découvrir
                </TitleCard>
                <Box sx={{ height: '4px', width: '3rem', backgroundColor: '#689f38', marginLeft: '1rem' }} />
            </Box>
            <TitleCard sx={{ fontWeight: 'bold', textAlign: 'center', marginBottom: 3 }}> Les Catégories </TitleCard>
            <Grid container spacing={2} sx={{ justifyContent: 'center' }}>
                <Grid item xs={6} sm={4} sx={{ display: 'flex', justifyContent: 'center', marginBottom: 3 }} >
                    <Link to="/categorie/1">
                    <Card sx={{ maxWidth: '400px' }}>
                        <CardMedia
                            sx={{ mawHeight: '400px' }}
                            component="img"
                            image="Categories/racaille.png"
                            alt="menhir"
                        />
                    </Card>
                    </Link>
                </Grid>
                <Grid item xs={6} sm={4} sx={{ display: 'flex', justifyContent: 'center', marginBottom: 3 }} >
                    <Link to="/categorie/2">
                    <Card sx={{ maxWidth: '400px' }}>
                        <CardMedia
                            sx={{ mawHeight: '400px' }}
                            component="img"
                            image="Categories/menhirCat.png"
                            alt="menhir"
                        />
                    </Card>
                    </Link>
                </Grid>
                <Grid item xs={6} sm={4} sx={{ display: 'flex', justifyContent: 'center', marginBottom: 3 }} >
                    <Link to="/categorie/3">
                    <Card sx={{ maxWidth: '400px' }}>
                        <CardMedia
                            sx={{ mawHeight: '400px' }}
                            component="img"
                            image="Categories/diamond.png"
                            alt="menhir"
                        />
                    </Card>
                    </Link>
                </Grid>
            </Grid>
        </Box>

    );
}

export default HomeCategory;