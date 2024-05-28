import { render, screen } from '@testing-library/react';
import ProductsList from '../components/HomePage/ProductsList';

describe('ProductsList', () => {
  test('renders the title', () => {
    render(<ProductsList />);
    const titleElement = screen.getByText('Quelques idées');
    expect(titleElement).toBeInTheDocument();
  });

});