import { useState } from "react";
import { Box, TextField, Button, Grid, FormControl, InputLabel, OutlinedInput, InputAdornment, IconButton, Snackbar, Alert } from "@mui/material";
import TitleCard from "../tools/Typography/TitleCard";
import Body from "../tools/Typography/Body";
import { Link } from 'react-router-dom';
import { Visibility, VisibilityOff } from "@mui/icons-material";
import { useApi } from "../../Provider/ApiProvider";
import { useNavigate } from "react-router-dom";



function LoginPage() {

    const [showPassword, setShowPassword] = useState(false);
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [open, setOpen] = useState(false);
    const navigate = useNavigate();

    const api = useApi();
    const { login } = api;

    const handleClickShowPassword = () => setShowPassword((show) => !show);
    const handleMouseDownPassword = (event: React.MouseEvent<HTMLButtonElement>) => {
        event.preventDefault();
    };

    const handleSubmit = async (event: React.FormEvent) => {
        event.preventDefault();
        const user = {
            email,
            password
        }
        try {
            await login(user);
            navigate('/');
        } catch (error) {
            console.error('Failed to login', error);
            setOpen(true);
        }
    };

    return (
        <Box sx={{ height: "80vh", width: "80vw", margin: '0 auto', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center' }}>
            <TitleCard>Connexion</TitleCard>
            <form style={{ textAlign: 'center' }} onSubmit={handleSubmit}>
                <Grid container spacing={2}>
                    <Grid item xs={12}>
                        <FormControl sx={{ m: 1, width: { xs: '30ch', md: '50ch' } }}>
                            <TextField
                                type="email"
                                label="Email"
                                variant="outlined"
                                margin="normal"
                                value={email}
                                onChange={(e: React.ChangeEvent<HTMLInputElement>) => setEmail(e.target.value)}
                            />
                        </FormControl>
                    </Grid>
                    <Grid item xs={12}>
                        <FormControl sx={{ m: 1, width: { xs: '30ch', md: '50ch' } }} variant="outlined">
                            <InputLabel htmlFor="outlined-adornment-password">Mot de passe</InputLabel>
                            <OutlinedInput
                                id="outlined-adornment-password"
                                type={showPassword ? 'text' : 'password'}
                                endAdornment={
                                    <InputAdornment position="end">
                                        <IconButton
                                            aria-label="toggle password visibility"
                                            onClick={handleClickShowPassword}
                                            onMouseDown={handleMouseDownPassword}
                                            edge="end"
                                        >
                                            {showPassword ? <VisibilityOff /> : <Visibility />}
                                        </IconButton>
                                    </InputAdornment>
                                }
                                label="Mot de passe"
                                value={password}
                                onChange={(e: React.ChangeEvent<HTMLInputElement>) => setPassword(e.target.value)}
                            />
                        </FormControl>
                    </Grid>
                    <Grid item xs={12}>
                        <Button variant="contained" color="primary" type="submit">
                            Valider
                        </Button>
                    </Grid>
                </Grid>
            </form>
            <Grid container spacing={2} sx={{ textAlign: 'center', marginTop: 2 }}>
                <Grid item xs={12}>
                    <Body> Pas encore inscrit ? <Link to="/register">C'est ici !</Link></Body>
                </Grid>
            </Grid>
            <Snackbar open={open} autoHideDuration={5000} onClose={() => setOpen(false)}>
                <Alert onClose={() => setOpen(false)} severity="error" sx={{ width: '100%' }}>
                    Email ou Mot de passe incorrect
                </Alert>
            </Snackbar>
        </Box>
    )
}
export default LoginPage;