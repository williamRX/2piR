import { render, screen } from '@testing-library/react';
import HomeProduct from '../components/HomePage/HomeProduct';

describe('HomeProduct', () => {
  test('renders the title', () => {
    render(<HomeProduct />);
    const titleElement = screen.getByText('Notre produit phare');
    expect(titleElement).toBeInTheDocument();
  });

  test('renders the product image', () => {
    render(<HomeProduct />);
    const imageElement = screen.getByAltText('menhir');
    expect(imageElement).toBeInTheDocument();
    expect(imageElement.getAttribute('src')).toBe('menhir.jpg');
  });

  test('renders the product name', () => {
    render(<HomeProduct />);
    const nameElement = screen.getByText('Menhir');
    expect(nameElement).toBeInTheDocument();
  });

  test('renders the product description', () => {
    render(<HomeProduct />);
    const descriptionElement = screen.getByText(
      'Le menhir est une pierre dressée, le plus souvent brute, qui se distingue d\'un autre type de pierre dressée, la stèle, par son absence de sculpture ou de gravure.'
    );
    expect(descriptionElement).toBeInTheDocument();
  });

  test('renders the product price', () => {
    render(<HomeProduct />);
    const priceElement = screen.getByText('1000€');
    expect(priceElement).toBeInTheDocument();
  });

  test('renders the "Commander" button', () => {
    render(<HomeProduct />);
    const buttonElement = screen.getByText('Commander');
    expect(buttonElement).toBeInTheDocument();
  });
});