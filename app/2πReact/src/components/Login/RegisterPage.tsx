import React, { useState } from "react";
import { Box, TextField, Button, Grid, InputLabel, OutlinedInput, InputAdornment, IconButton, FormHelperText } from "@mui/material";
import TitleCard from "../tools/Typography/TitleCard";
import Visibility from '@mui/icons-material/Visibility';
import VisibilityOff from '@mui/icons-material/VisibilityOff';
import FormControl from '@mui/material/FormControl';
import { useApi } from "../../Provider/ApiProvider";
import { useNavigate } from "react-router-dom";

interface RegisterPageProps {
    setOpenSnackbar: (value: boolean) => void;
}

function RegisterPage({ setOpenSnackbar }: RegisterPageProps) {

    const api = useApi();
    const { createUser } = api;

    const [showPassword, setShowPassword] = useState(false);
    const [showConfirmPassword, setShowConfirmPassword] = useState(false);

    const [password, setPassword] = useState('');
    const [username, setUsername] = useState('');
    const [firstname, setFirstname] = useState('');
    const [lastname, setLastname] = useState('');
    const [email, setEmail] = useState('');

    const navigate = useNavigate();


    const [confirmPassword, setConfirmPassword] = useState('');
    const [error, setError] = useState(false);
    const [errorMessage, setErrorMessage] = useState('');
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$/;

    const handleClickShowPassword = () => setShowPassword((show) => !show);

    const handleClickShowConfirmPassword = () => {
        setShowConfirmPassword(!showConfirmPassword);
    };

    const handleMouseDownPassword = (event: React.MouseEvent<HTMLButtonElement>) => {
        event.preventDefault();
    };

    const handleSubmit = async (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        if (password !== confirmPassword) {
            setError(true);
            setErrorMessage('Les mots de passe ne correspondent pas.');
            return;
        }
        if (!passwordRegex.test(password)) {
            setError(true);
            setErrorMessage('Le mot de passe doit contenir au moins 10 caractères, une majuscule, un chiffre et un caractère spécial.');
            return;
        }
        const userData = {
            username,
            firstname,
            lastname,
            email,
            password,
        };
        setError(false);
        setErrorMessage('');
        try {
            await createUser(userData);
            navigate('/login');
            setOpenSnackbar(true);
        } catch (error) {
            console.error(error);
        }
    };

    return (
        <Box sx={{ height: "80vh", width: "80vw", margin: '0 auto', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center' }}>
            <TitleCard>Inscription</TitleCard>
            <form style={{ textAlign: 'center' }} onSubmit={handleSubmit}>
                <Grid container spacing={2}>
                    <Grid item xs={12}>
                        <TextField
                            sx={{ width: { xs: '30ch', md: '60ch' } }}
                            label="Nom d'utilisateur"
                            variant="outlined"
                            margin="normal"
                            value={username}
                            onChange={(e: React.ChangeEvent<HTMLInputElement>) => setUsername(e.target.value)}
                        />
                    </Grid>
                    <Grid item xs={6} container justifyContent="flex-end">
                        <TextField
                            sx={{ width: { xs: '14ch', md: '29ch' } }}
                            label="Nom"
                            variant="outlined"
                            margin="normal"
                            value={lastname}
                            onChange={(e: React.ChangeEvent<HTMLInputElement>) => setLastname(e.target.value)}
                        />
                    </Grid>
                    <Grid item xs={6} container justifyContent="flex-start">
                        <TextField
                            sx={{ width: { xs: '14ch', md: '29ch' } }}
                            label="Prénom"
                            variant="outlined"
                            margin="normal"
                            value={firstname}
                            onChange={(e: React.ChangeEvent<HTMLInputElement>) => setFirstname(e.target.value)}
                        />
                    </Grid>
                    <Grid item xs={12}>
                        <FormControl sx={{ width: { xs: '30ch', md: '60ch' } }}>
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
                        <FormControl sx={{ m: 1, width: { xs: '30ch', md: '60ch' } }} variant="outlined">
                            <InputLabel htmlFor="outlined-adornment-password">Mot de passe</InputLabel>
                            <OutlinedInput
                                id="outlined-adornment-password"
                                type={showPassword ? 'text' : 'password'}
                                onChange={(e: React.ChangeEvent<HTMLInputElement>) => setPassword(e.target.value)}
                                error={error}
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
                            />
                            {error && <FormHelperText error>{errorMessage}</FormHelperText>}
                        </FormControl>
                    </Grid>
                    <Grid item xs={12}>
                        <FormControl sx={{ m: 1, width: { xs: '30ch', md: '60ch' } }} variant="outlined">
                            <InputLabel htmlFor="outlined-adornment-confirm-password">Confirmer</InputLabel>
                            <OutlinedInput
                                onChange={(e: React.ChangeEvent<HTMLInputElement>) => setConfirmPassword(e.target.value)}
                                id="outlined-adornment-confirm-password"
                                type={showConfirmPassword ? 'text' : 'password'}
                                error={error}
                                endAdornment={
                                    <InputAdornment position="end">
                                        <IconButton
                                            aria-label="toggle password visibility"
                                            onClick={handleClickShowConfirmPassword}
                                            onMouseDown={handleMouseDownPassword}
                                            edge="end"

                                        >
                                            {showConfirmPassword ? <VisibilityOff /> : <Visibility />}
                                        </IconButton>
                                    </InputAdornment>
                                }
                                label="Confirmer"
                            />
                            {error && <FormHelperText error>{errorMessage}</FormHelperText>}
                        </FormControl>
                    </Grid>
                    <Grid item xs={12}>
                        <Button variant="contained" color="primary" type="submit">
                            Valider
                        </Button>
                    </Grid>
                </Grid>
            </form>
        </Box>
    )
}
export default RegisterPage;