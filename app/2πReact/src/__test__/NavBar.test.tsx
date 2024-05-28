import { render, screen } from '@testing-library/react';
import NavBar from '../components/NavBar/NavBar';
import { BrowserRouter } from 'react-router-dom';

describe('NavBar', () => {
  test('renders the logo', () => {
    render(      
    <BrowserRouter>
      <NavBar />
  </BrowserRouter>
  );
    const logoElement = screen.getByAltText('logo');
    expect(logoElement).toBeInTheDocument();
  });


  test('displays the search input', () => {
    render(
      <BrowserRouter>
        <NavBar />
    </BrowserRouter>
    );
    const searchInput = screen.getByPlaceholderText('Rechercher un produit ...');
    expect(searchInput).toBeInTheDocument();
  });
});