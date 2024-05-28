<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use App\Entity\ProductCart;
use App\Repository\ProductRepository;
use App\Repository\ProductCartRepository;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends AbstractController
{
    private $userRepository;
    private $serializer;
    private $validator;
    private $productCartRepository;

    public function __construct(
        UserRepository $userRepository,
        ProductRepository $productRepository,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager, // Ajouter cette ligne
        ProductCartRepository $productCartRepository
    ) {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->entityManager = $entityManager;  // Et initialiser ici
        $this->productCartRepository = $productCartRepository;
    }

    // #[Route('/users', name: 'user_index', methods: ['GET'])]
    // public function index(): JsonResponse
    // {
    //     $users = $this->userRepository->findAll();
    //     return $this->json($users);
    // }
    #[Route('/users_', name: 'app_users_json')]
    public function usersJson(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
    
        $usersArray = array_map(function ($user) {
            if (!$user) {
                throw new \Exception("Utilisateur non chargé");
            }
        
            $userDetails = [
                'id' => $user->getId(),
                'login' => $user->getUsername(),  
            ];
        
            $productCartsArray = [];
            foreach ($user->getProductCarts() as $productCart) {
                if (!$productCart) {
                    throw new \Exception("Panier de produits non chargé");
                }
                $productCartsArray[] = ['id' => $productCart->getId()];
            }
    
            $productWishlistsArray = [];
            foreach ($user->getProductWishlists() as $productWishlist) {
                $productWishlistsArray[] = [
                    'id' => $productWishlist->getId(),
                ];
            }
    
            $OrdersArray = [];
            foreach ($user->getOrders() as $order) {
                if (!$order) {
                    throw new \Exception("Commande non chargée");
                }
                $OrdersArray[] = ['id' => $order->getId()];
            }
        
            return [
                'id' => $userDetails['id'],
                'login' => $userDetails['login'],
                'password' => $user->getPassword(),
                'email'=> $user->getEmail(),
                'firstname' => $user->getFirstname(),
                'lastname'=> $user->getLastname(),
                'custom' => [
                    'orders' => $OrdersArray,
                    'product_carts' => $productCartsArray,
                    'product_wishlists' => $productWishlistsArray,
                ]
            ];
        }, $users);
    
        return new JsonResponse($usersArray);
    }
    


    #[Route('/users', name: 'user_info', methods: ['GET'])]
    public function getUserInfo(JWTEncoderInterface $jwtEncoder, UserRepository $userRepository, Request $request): JsonResponse
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

        $userDetails = [
            'id' => $user->getId(),
            'login' => $user->getUsername(),  
        ];

        $productCartsArray = [];
        foreach ($user->getProductCarts() as $productCart) {
            if (!$productCart) {
                throw new \Exception("Panier de produits non chargé");
            }
            $productCartsArray[] = ['id' => $productCart->getId()];
        }

        $productWishlistsArray = [];
        foreach ($user->getProductWishlists() as $productWishlist) {
            $productWishlistsArray[] = [
                'id' => $productWishlist->getId(),
            ];
        }

        $OrdersArray = [];
        foreach ($user->getOrders() as $order) {
            if (!$order) {
                throw new \Exception("Commande non chargée");
            }
            $OrdersArray[] = ['id' => $order->getId()];
        }

        $userInfo = [
            'id' => $userDetails['id'],
            'login' => $userDetails['login'],
            'password' => $user->getPassword(),
            'email'=> $user->getEmail(),
            'firstname' => $user->getFirstname(),
            'lastname'=> $user->getLastname(),
            'custom' => [
                'orders' => $OrdersArray,
                'product_carts' => $productCartsArray,
                'product_wishlists' => $productWishlistsArray,
            ]
        ];

        return $this->json($userInfo);
    }


    #[Route('/users', name: 'user_update', methods: ['PUT'])]
    public function updateUserInfo(JWTEncoderInterface $jwtEncoder, UserRepository $userRepository, Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): JsonResponse
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

        $requestData = json_decode($request->getContent(), true);

        if (isset($requestData['username'])) {
            $user->setUsername($requestData['username']);
        }

        if (isset($requestData['password'])) {
            $user->setPassword($passwordHasher->hashPassword($user, $requestData['password']));
        }

        if (isset($requestData['email'])) {
            $user->setEmail($requestData['email']);
        }

        if (isset($requestData['firstname'])) {
            $user->setFirstname($requestData['firstname']);
        }

        if (isset($requestData['lastname'])) {
            $user->setLastname($requestData['lastname']);
        }

        // Add other fields if needed

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(['message' => 'User updated']);
    }


    #[Route('/user/{id}', name: 'user_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            return $this->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        return $this->json($user);
    }


    #[Route('/register', name: 'user_create', methods: ['POST'])]
    public function create(Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $user = $this->serializer->deserialize($request->getContent(), User::class, 'json');

        // Hash the password
        $user->setPassword(
            $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            )
        );

        $errors = $this->validator->validate($user);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $this->userRepository->add($user, true);
        
            return $this->json($user, Response::HTTP_CREATED);
        }

    #[Route('/user/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            return $this->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $this->userRepository->remove($user, true);
        return $this->json(['message' => 'User deleted']);
    }
    
    #[Route("/login", name: "login", methods: ["POST"])]
    public function login(Request $request, UserPasswordHasherInterface $passwordHasher, JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'];
        $password = $data['password'];

        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user || !$passwordHasher->isPasswordValid($user, $password)) {
            return $this->json(['message' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }

        $token = $JWTManager->create($user);

        return $this->json(['token' => $token]);
    }


    #[Route('/usersproducts/add/{userId}/{productId}/{quantity}', name: 'add_product_to_user', methods: ['POST'])]
    public function addProductToUser(int $userId, int $productId, int $quantity): JsonResponse
    {
        $user = $this->userRepository->find($userId);
        if (!$user) {
            return $this->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $product = $this->productRepository->find($productId);
        if (!$product) {
            return $this->json(['message' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $productCart = $this->productCartRepository->findOneBy(['user' => $user, 'product' => $product]);

        if ($productCart) {
            // If the product is already in the cart, increase the quantity
            $productCart->setQuantity($productCart->getQuantity() + $quantity);
        } else {
            // If the product is not in the cart, add it
            $productCart = new ProductCart();
            $productCart->setProduct($product);
            $productCart->setUser($user);
            $productCart->setQuantity($quantity);
            $this->entityManager->persist($productCart);
        }

        $this->entityManager->flush();

        return $this->json(['message' => 'Product added to user cart successfully']);
    }

        
    

    #[Route('/usersproducts/remove/{userId}/{productId}/{quantity}', name: 'remove_product_from_user', methods: ['DELETE'])]
    public function removeProductFromUser(int $userId, int $productId, int $quantity): JsonResponse
    {
        $user = $this->userRepository->find($userId);
        if (!$user) {
            return $this->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $productCart = $this->productCartRepository->findOneBy(['user' => $user, 'product' => $productId]);
        if (!$productCart) {
            return $this->json(['message' => 'Product not found in user cart'], Response::HTTP_NOT_FOUND);
        }

        if ($productCart->getQuantity() > $quantity) {
            $productCart->setQuantity($productCart->getQuantity() - $quantity);
        } else {
            $this->entityManager->remove($productCart);
        }

        $this->entityManager->flush();

        return $this->json(['message' => 'Product removed from user cart successfully']);
    }
    

}
