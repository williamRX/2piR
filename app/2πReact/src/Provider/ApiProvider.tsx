import React, { createContext, useContext, useState } from 'react';
import { Product, User, UserLogin, ApiContextType, OrderInfo } from '../type';


export const ApiContext = createContext<ApiContextType | null>(null);

export function ApiProvider({ children }: { children: React.ReactNode }) {

    const [cart, setCart] = useState<Product[]>([]);

    const addToCart = async (product: Product) => {
        const token = localStorage.getItem('token');
        if (!token) {
            throw new Error('No token found');
        }
        const response = await fetch(`http://localhost:8080/api/carts/${product.id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `${token}`,
            },
            body: JSON.stringify({ quantity: product.quantity }),
        });
        if (!response.ok) {
            throw new Error('Failed to add product to cart');
        }
        const storedCart = JSON.parse(localStorage.getItem('cart') || '[]');
        const productIndex = storedCart.findIndex((p: Product) => p.id === product.id);
    
        if (productIndex !== -1) {
            storedCart[productIndex].quantity += product.quantity;
        } else {
            storedCart.push(product);
        }
        localStorage.setItem('cart', JSON.stringify(storedCart));
        window.dispatchEvent(new Event('cartChanged'));
        setCart(storedCart);
    }

    const deleteFromCart = async (product: Product) => {
        const token = localStorage.getItem('token');
        if (!token) {
            throw new Error('No token found');
        }
        const response = await fetch(`http://localhost:8080/api/carts/${product.id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `${token}`,
            },
        });
        if (!response.ok) {
            throw new Error('Failed to delete product from cart');
        }
        const storedCart = JSON.parse(localStorage.getItem('cart') || '[]');
        const productIndex = storedCart.findIndex((p: Product) => p.id === product.id);
        if (productIndex !== -1) {
            storedCart.splice(productIndex, 1);
        }
        localStorage.setItem('cart', JSON.stringify(storedCart));
        window.dispatchEvent(new Event('cartChanged'));
        setCart(storedCart);
    }

    const createOrder = async (orderInfo: OrderInfo) => {
        const token = localStorage.getItem('token');
        if (!token) {
            throw new Error('No token found');
        }
        const response = await fetch('http://localhost:8080/api/orders', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `${token}`,
            },
            body: JSON.stringify(orderInfo),
        });
        console.log(orderInfo)
        if (!response.ok) {
            throw new Error('Failed to create order');
        }
    }

    const getOrder = async () => {
        const token = localStorage.getItem('token');
        if (!token) {
            throw new Error('No token found');
        }
        const response = await fetch('http://localhost:8080/api/orders', {
            headers: {
                'Authorization': `${token}`,
            },
        });
        if (!response.ok) {
            throw new Error('Failed to fetch orders');
        }
        return response.json();
    }

    const validateOrder = async (id:Number) => {
        const token = localStorage.getItem('token');
        if (!token) {
            throw new Error('No token found');
        }
        const response = await fetch(`http://localhost:8080/api/carts/validate/${id}`, {
            method: 'POST',
            headers: {
                'Authorization': `${token}`,
            },
        });
        if (!response.ok) {
            throw new Error('Failed to fetch orders');
        }
        return response.json();
    }

    const getAllOrder = async () => {
        const token = localStorage.getItem('token');
        if (!token) {
            throw new Error('No token found');
        }
        const response = await fetch('http://localhost:8080/api/product_order',{
            headers: {
                'Authorization': `${token}`,
            },
        });
        if (!response.ok) {
            throw new Error('Failed to fetch orders');
        }
        return response.json();
    }

    
    const login = async (user: UserLogin) => {
        const response = await fetch('http://localhost:8080/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(user),
        });
        if (!response.ok) {
            throw new Error('Failed to login');
        }
        const data = await response.json();
        localStorage.setItem('token', data.token);
    }


    const createUser = async (userData: User) => {
        const response = await fetch('http://localhost:8080/api/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(userData),
        });
        if (!response.ok) {
            throw new Error('Failed to create user');
        }
        return response.json();
    };

    const getProducts = async () => {
        const response = await fetch('http://localhost:8080/api/products');
        if (!response.ok) {
            throw new Error('Failed to fetch products');
        }
        return response.json();
    };

    const getProductsByCategory = async (id: number) => {
        const response = await fetch(`http://localhost:8080/api/product_cat/${id} `);
        if (!response.ok) {
            throw new Error('Failed to fetch products');
        }
        return response.json();
    }

    const getProductById = async (id: number) => {
        const response = await fetch(`http://localhost:8080/api/products/${id} `);
        if (!response.ok) {
            throw new Error('Failed to fetch products');
        }
        return response.json();
    }

    const createCustomer = async () => {
        const token = localStorage.getItem('token');
        if (!token) {
            throw new Error('No token found');
        }
        const response = await fetch('http://localhost:8080/api/create-customer',{
            method: 'POST',
            headers: {
                'Authorization': `${token}`,
            },
        });
        if (!response.ok) {
            throw new Error('Failed to fetch orders');
        }
        return response.json();
    }

    const validatePayment = async (orderId: number, customerId: string) => {
        const token = localStorage.getItem('token');
        if (!token) {
            throw new Error('No token found');
        }
        const response = await fetch('http://localhost:8080/api/payment/charge',{
            method: 'POST',
            headers: {
                'Authorization': `${token}`,
            },
            body: JSON.stringify({orderId, customerId}),
        });
        if (!response.ok) {
            throw new Error('Failed to fetch orders');
        }
        return response.json();
    }


    return (
        <ApiContext.Provider value={{ createUser, getProducts, getProductsByCategory, getProductById, login, addToCart, cart, deleteFromCart, createOrder, getOrder, validateOrder, getAllOrder, createCustomer, validatePayment}}>
            {children}
        </ApiContext.Provider>
    );
}

export function useApi() {
    const context = useContext(ApiContext);
    if (!context) {
        throw new Error('Api context must be used within an ApiProvider');
    }
    return context;
}