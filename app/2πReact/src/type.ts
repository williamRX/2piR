export interface Product {
    id: number;
    name: string;
    price: number;
    photo: string;
    description: string;
    quantity?: number;
}

export interface UserLogin {
    email: string;
    password: string;
}

export interface User {
    username: string;
    password: string;
    email: string;
    firstname: string;
    lastname: string;
}

export interface OrderInfo {
    total_price: number,
    shipping_address: string,
    shipping_city: string,
    shipping_state: string,
    shipping_postal_code: string,
    shipping_country: string,
    payment_method: string,
    payment_status: string
}

export interface Order {
    creation_date: string;
    id: number;
    payment_method: string;
    payment_status: string;
    shipping_address: string;
    shipping_city: string;
    total_price: number;
}

export interface ProductOrder {
    order_id: number;
    product_name: string;
    product_price: number;
    quantity: number;
    product_photo: string;
  }
  
  export interface CustomerResponse {
    customerId: string;
}

export interface ApiContextType {
    createUser: (userData: User) => Promise<any>;
    getProducts: () => Promise<any>;
    getProductsByCategory: (id: number) => Promise<any>;
    getProductById: (id: number) => Promise<any>;
    login: (user: UserLogin) => Promise<void>;
    addToCart: (product: Product) => Promise<void>;
    cart: Product[];
    deleteFromCart: (product: Product) => Promise<void>;
    createOrder: (orderInfo: OrderInfo) => Promise<void>;
    getOrder: () => Promise<any>;
    validateOrder: (orderId: number) => Promise<void>;
    getAllOrder: () => Promise<any>;
    createCustomer: () => Promise<CustomerResponse>;
    validatePayment: (orderId: number, customerId: string) => Promise<void>;
}
