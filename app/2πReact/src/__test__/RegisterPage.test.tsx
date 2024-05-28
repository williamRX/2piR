import { render, screen, fireEvent } from '@testing-library/react';
import RegisterPage from '../components/Login/RegisterPage';
import { ApiProvider } from '../Provider/ApiProvider';


describe('RegisterPage', () => {
  test('renders the registration form', () => {
    render(
      <ApiProvider>
        <RegisterPage />
      </ApiProvider>
    );
    
    const titleElement = screen.getByText('Inscription');
    expect(titleElement).toBeInTheDocument();

    const usernameInput = screen.getByLabelText('Nom d\'utilisateur');
    expect(usernameInput).toBeInTheDocument();

    const firstnameInput = screen.getByLabelText('Prénom');
    expect(firstnameInput).toBeInTheDocument();

    const lastnameInput = screen.getByLabelText('Nom');
    expect(lastnameInput).toBeInTheDocument();

    const emailInput = screen.getByLabelText('Email');
    expect(emailInput).toBeInTheDocument();

    const passwordInput = screen.getByLabelText('Mot de passe');
    expect(passwordInput).toBeInTheDocument();

    const confirmPasswordInput = screen.getByLabelText('Confirmer');
    expect(confirmPasswordInput).toBeInTheDocument();

    const submitButton = screen.getByRole('button', { name: 'Valider' });
    expect(submitButton).toBeInTheDocument();
  });

  test('validates password and confirm password match', async () => {
    render(
      <ApiProvider>
        <RegisterPage />
      </ApiProvider>
    );
    
    const passwordInput = screen.getByLabelText('Mot de passe');
    const confirmPasswordInput = screen.getByLabelText('Confirmer');
    const submitButton = screen.getByRole('button', { name: 'Valider' });
  
    fireEvent.change(passwordInput, { target: { value: 'password' } });
    fireEvent.change(confirmPasswordInput, { target: { value: 'differentpassword' } });
    fireEvent.click(submitButton);
  
    const errorMessages = await screen.findAllByText('Les mots de passe ne correspondent pas.');
    expect(errorMessages).toHaveLength(2); 
  });

  test('validates password complexity', async () => {
    render(
      <ApiProvider>
        <RegisterPage />
      </ApiProvider>
    );
    
    const passwordInput = screen.getByLabelText('Mot de passe');
    const confirmPasswordInput = screen.getByLabelText('Confirmer');
    const submitButton = screen.getByRole('button', { name: 'Valider' });
  
    fireEvent.change(passwordInput, { target: { value: 'password' } });
    fireEvent.change(confirmPasswordInput, { target: { value: 'password' } });
    fireEvent.click(submitButton);
  
    const errorMessages = await screen.findAllByText('Le mot de passe doit contenir au moins 10 caractères, une majuscule, un chiffre et un caractère spécial.');
    expect(errorMessages).toHaveLength(2); 
  });

});