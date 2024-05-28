import { render, screen } from '@testing-library/react';
import HomeCategory from '../components/HomePage/HomeCategory';

describe('HomeCategory', () => {
  test('renders the category title', () => {
    render(<HomeCategory />);
    const categoryTitle = screen.getByText('Les Catégories');
    expect(categoryTitle).toBeInTheDocument();
  });

  test('renders the category images', () => {
    render(<HomeCategory />);
    const categoryImages = screen.getAllByRole('img');
    expect(categoryImages).toHaveLength(3);
  });
});