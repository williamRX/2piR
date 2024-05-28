<?php

namespace App\Controller;

use App\Entity\ProductOrder;
use App\Entity\ProductCart;
use App\Entity\Order;
use App\Repository\ProductCartRepository;
use App\Repository\UserRepository;
use App\Repository\ProductOrderRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class ProductOrderController extends AbstractController
{
    
    
    #[Route('/product_order', name: 'app_product_order')]
    public function index(ProductOrderRepository $productOrderRepository): JsonResponse
    {
        $orders = $productOrderRepository->findAll();

        $ordersArray = array_map(function (ProductOrder $order) {
            return [
                'order_id' => $order->getId(),
                'quantity' => $order->getQuantity(),
                'order_id' => $order->getOrder()->getId(),
                'product_id' => $order->getProduct()->getId(),
                'product_name' => $order->getProduct()->getName(), 
                'product_photo' => $order->getProduct()->getPhoto(),
                'product_price' => $order->getProduct()->getPrice(),
                'payment_status' => $order->getOrder()->getPaymentStatus(),
            ];
        }, $orders);

        return $this->json($ordersArray);
    }



    #[Route('/product_order/{order_id}/{user_id}', name: 'app_product_order_show')]
    public function show($order_id, $user_id, UserRepository $userRepository, OrderRepository $orderRepository, ProductOrderRepository $productOrderRepository): Response
    {
        $user = $userRepository->find($user_id);

        if (!$user) {
            return $this->json(['message' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $order = $orderRepository->findOneBy(['id' => $order_id, 'user' => $user]);

        if (!$order) {
            return $this->json(['message' => 'No order found for user'], JsonResponse::HTTP_NOT_FOUND);
        }

        $productOrders = $productOrderRepository->findBy(['order' => $order]);

        if (!$productOrders) {
            return $this->json(['message' => 'No product orders found for order'], JsonResponse::HTTP_NOT_FOUND);
        }

        $productOrdersArray = [];
        foreach ($productOrders as $productOrder) {
            $productOrdersArray[] = [
                'id' => $productOrder->getId(),
                'product' => $productOrder->getProduct()->getName(),
                'quantity' => $productOrder->getQuantity(),
                // Add more fields as needed
            ];
        }

        return $this->json($productOrdersArray);
    }

    #[Route('/product_order/remove/{id}', name: 'app_product_order_remove', methods: ['DELETE'])]
    public function remove(ProductOrder $order): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($order);
        $entityManager->flush();

        return $this->redirectToRoute('app_product_order');
    }


    #[Route('/product_order/create_from_cart/{cartId}/{orderId}', name: 'product_order_create_from_cart', methods: ['POST'])]
    public function createFromCart(int $cartId, int $orderId, EntityManagerInterface $entityManager): JsonResponse
    {
        $productCart = $entityManager->getRepository(ProductCart::class)->find($cartId);
        if (!$productCart) {
            throw $this->createNotFoundException('No product cart found for id '.$cartId);
        }

        $order = $entityManager->getRepository(Order::class)->find($orderId);
        if (!$order) {
            throw $this->createNotFoundException('No order found for id '.$orderId);
        }

        $productOrder = new ProductOrder();
        $productOrder->setOrder($order);
        $productOrder->setProduct($productCart->getProduct());
        $productOrder->setQuantity($productCart->getQuantity());
        // Set user if ProductOrder has a user property
        // $productOrder->setUser($productCart->getUser());

        $entityManager->persist($productOrder);
        $entityManager->flush();

        return $this->json(['status' => 'Product order created from cart'], Response::HTTP_CREATED);
    }

    #[Route('/product_order/create_from_user_cart/{userId}/{orderId}', name: 'product_order_create_from_user_cart', methods: ['POST'])]
    public function createFromUserCart(int $userId, int $orderId, EntityManagerInterface $entityManager): JsonResponse
    {
        $userCarts = $entityManager->getRepository(ProductCart::class)->findBy(['user' => $userId]);
        if (!$userCarts) {
            throw $this->createNotFoundException('No product carts found for user id '.$userId);
        }
    
        $order = $entityManager->getRepository(Order::class)->find($orderId);
        if (!$order) {
            throw $this->createNotFoundException('No order found for id '.$orderId);
        }
    
        $totalPrice = 0;
    
        foreach ($userCarts as $productCart) {
            $productOrder = new ProductOrder();
            $productOrder->setOrder($order);
            $productOrder->setProduct($productCart->getProduct());
            $productOrder->setQuantity($productCart->getQuantity());
            // Set user if ProductOrder has a user property
            // $productOrder->setUser($productCart->getUser());
    
            $entityManager->persist($productOrder);
            // Remove the product cart
            $entityManager->remove($productCart);
    
            // Update the total price
            $totalPrice += $productCart->getProduct()->getPrice() * $productCart->getQuantity();
        }
    
        // Set the total price of the order
        $order->setTotalPrice($totalPrice);
    
        $entityManager->flush();
    
        return $this->json(['status' => 'Product orders created from user cart and cart emptied'], Response::HTTP_CREATED);
    }
   
    #[Route('/carts/validate/{order_id}', name: 'carts_validate', methods: ['POST'])]
    public function validateCart($order_id, Request $request, JWTEncoderInterface $jwtEncoder, UserRepository $userRepository, OrderRepository $orderRepository, ProductOrderRepository $productOrderRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $token = $request->headers->get('Authorization');
        $data = [];

        try {
            $data = $jwtEncoder->decode($token);
        } catch (\Exception $exception) {
            // handle exception
            return $this->json(['message' => 'Invalid token'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $username = $data['username'];
        $user = $userRepository->findOneBy(['username' => $username]);

        if (!$user) {
            return $this->json(['message' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $order = $orderRepository->findOneBy(['id' => $order_id, 'user' => $user]);

        if (!$order) {
            return $this->json(['message' => 'No order found for user'], JsonResponse::HTTP_NOT_FOUND);
        }

        $userCarts = $entityManager->getRepository(ProductCart::class)->findBy(['user' => $user]);

        if (!$userCarts) {
            return $this->json(['message' => 'No product carts found for user'], JsonResponse::HTTP_NOT_FOUND);
        }

        $totalPrice = 0;

        foreach ($userCarts as $productCart) {
            $productOrder = new ProductOrder();
            $productOrder->setOrder($order);
            $productOrder->setProduct($productCart->getProduct());
            $productOrder->setQuantity($productCart->getQuantity());

            $product = $productCart->getProduct();
            $quantity = $productCart->getQuantity();

            if ($product->getStockQuantity() < $quantity) {
                return $this->json(['message' => 'Not enough stock for product ' . $product->getId()], JsonResponse::HTTP_BAD_REQUEST);
            }

            $product->setStockQuantity($product->getStockQuantity() - $quantity);
            $entityManager->persist($product);

            $entityManager->persist($productOrder);
            $entityManager->remove($productCart);

            $totalPrice += $productCart->getProduct()->getPrice() * $productCart->getQuantity();
        }

        $order->setTotalPrice($totalPrice);

        $entityManager->flush();

        return $this->json(['status' => 'Product orders created from user cart and cart emptied'], Response::HTTP_CREATED);
    }

}