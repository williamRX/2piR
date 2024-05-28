<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductCart;
use App\Repository\ProductRepository;
use App\Repository\ProductCartRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface; 
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Doctrine\ORM\EntityManagerInterface; 

class ProductCartController extends AbstractController
{

    #[Route('/carts', name: 'app_carts', methods: ['GET'])]
    public function getCarts(Request $request, UserRepository $userRepository, ProductCartRepository $productCartRepository, JWTEncoderInterface $jwtEncoder): JsonResponse
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

        $cartItems = $user->getProductCarts();

        $cartArray = array_map(function ($cartItem) {
            return [
                'cart_id' => $cartItem->getId(),
                'quantity' => $cartItem->getQuantity(),
                'product_id' => $cartItem->getProduct()->getId(),
                'product_name' => $cartItem->getProduct()->getName(),
                // Add more fields as needed...
            ];
        }, $cartItems->toArray());

        return $this->json($cartArray);
    }

    #[Route('/carts/{product_id}', name: 'app_carts_add', methods: ['POST'])]
    public function addToCart($product_id, Request $request, JWTEncoderInterface $jwtEncoder, UserRepository $userRepository, ProductRepository $productRepository, ProductCartRepository $productCartRepository, EntityManagerInterface $entityManager): JsonResponse
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

        $product = $productRepository->find($product_id);

        if (!$product) {
            return $this->json(['message' => 'Product not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Get quantity from the request body
        $data = json_decode($request->getContent(), true);
        $quantity = $data['quantity'];

        // Check if the product is already in the cart
        $productInCart = $productCartRepository->findOneBy(['user' => $user, 'product' => $product]);

        if ($productInCart) {
            // If the product is already in the cart, increase the quantity
            $productInCart->setQuantity($productInCart->getQuantity() + $quantity);
        } else {
            // If the product is not in the cart, add it
            $productInCart = new ProductCart();
            $productInCart->setUser($user);
            $productInCart->setProduct($product);
            $productInCart->setQuantity($quantity);
        }

        $entityManager->persist($productInCart);
        $entityManager->flush();

        return $this->json(['message' => 'Product added to cart successfully'], JsonResponse::HTTP_OK);
    }


    #[Route('/carts/{product_id}', name: 'app_carts_remove', methods: ['DELETE'])]
    public function removeFromCart($product_id, Request $request, JWTEncoderInterface $jwtEncoder, UserRepository $userRepository, ProductCartRepository $productCartRepository, EntityManagerInterface $entityManager): JsonResponse
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

        $cartItem = $productCartRepository->findOneBy(['user' => $user, 'product' => $product_id]);

        if (!$cartItem) {
            return $this->json(['message' => 'Product not found in cart'], JsonResponse::HTTP_NOT_FOUND);
        }

        $entityManager->remove($cartItem);
        $entityManager->flush();

        return $this->json(['message' => 'Product removed from cart']);
    }

    #[Route('/carts/{product_id}', name: 'app_carts_reduce', methods: ['PUT'])]
    public function reduceFromCart($product_id, Request $request, JWTEncoderInterface $jwtEncoder, UserRepository $userRepository, ProductRepository $productRepository, ProductCartRepository $productCartRepository, EntityManagerInterface $entityManager): JsonResponse
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
    
        $product = $productRepository->find($product_id);
    
        if (!$product) {
            return $this->json(['message' => 'Product not found'], JsonResponse::HTTP_NOT_FOUND);
        }
    
        // Get quantity from the request body
        $data = json_decode($request->getContent(), true);
        $quantity = $data['quantity'];
    
        // Check if the product is in the cart
        $productInCart = $productCartRepository->findOneBy(['user' => $user, 'product' => $product]);
    
        if ($productInCart) {
            // If the product is in the cart, decrease the quantity
            $productInCart->setQuantity($productInCart->getQuantity() - $quantity);
    
            // If the quantity of the product in the cart is less than or equal to 0, remove the product from the cart
            if ($productInCart->getQuantity() <= 0) {
                $entityManager->remove($productInCart);
            } else {
                $entityManager->persist($productInCart);
            }
    
            $entityManager->flush();
    
            return $this->json(['message' => 'Product quantity reduced successfully'], JsonResponse::HTTP_OK);
        } else {
            return $this->json(['message' => 'Product not found in cart'], JsonResponse::HTTP_NOT_FOUND);
        }
    }



    #[Route('/product_cart', name: 'app_product_cart', methods: ['GET'])]
    public function index(ProductCartRepository $productCartRepository): JsonResponse
    {
        $cart = $productCartRepository->findAll();

        $cartArray = array_map(function (ProductCart $cartItem) {
            return [
                'cart_id' => $cartItem->getId(),
                'quantity' => $cartItem->getQuantity(),
                'user_id' => $cartItem->getUser()->getId(),
                'username' => $cartItem->getUser()->getUsername(), // Add this line
                'product_id' => $cartItem->getProduct()->getId(),
                'product_name' => $cartItem->getProduct()->getName(), // And this line
                // Add more fields as needed...
            ];
        }, $cart);

        return $this->json($cartArray);
    }




   
    #[Route('/product_cart/{id}', name: 'app_product_cart_show', methods: ['GET'])]
    public function show(int $id, ProductCartRepository $productCartRepository): Response
    {
        $cartItems = $productCartRepository->findBy(['user' => $id]);

        return $this->render('product_cart/show.html.twig', [
            'cartItems' => $cartItems,
        ]);
    }


    #[Route('/product_cart/{id}', name: 'app_product_cart_add', methods: ['POST'])]
    public function add(Product $product): Response
    {
        $cartItem = new ProductCart();
        $cartItem->setProduct($product);
        $cartItem->setUser($this->getUser());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($cartItem);
        $entityManager->flush();

        return $this->redirectToRoute('app_product_cart');
    }

    #[Route('/product_cart/{id}', name: 'app_product_cart_remove', methods: ['DELETE'])]
    public function remove(ProductCart $cartItem): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($cartItem);
        $entityManager->flush();

        return $this->redirectToRoute('app_product_cart');
    }
}