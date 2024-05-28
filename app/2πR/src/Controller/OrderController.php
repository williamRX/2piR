<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;


class OrderController extends AbstractController
{
    private $orderRepository;
    private $serializer;
    private $validator;

    public function __construct(OrderRepository $orderRepository, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->orderRepository = $orderRepository;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }


    
    #[Route('/orders', name: 'order_index', methods: ['GET'])]
    public function index(Request $request, JWTEncoderInterface $jwtEncoder, UserRepository $userRepository, OrderRepository $orderRepository): JsonResponse
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

        $orders = $orderRepository->findBy(['user' => $user]);

        $ordersArray = array_map(function ($order) {
            return [
                'id' => $order->getId(),
                'total_price' => $order->getTotalPrice(),
                'creation_date' => $order->getCreationDate(),
                'shipping_address' => $order->getShippingAdress(),
                'shipping_city' => $order->getShippingCity(),
                'payment_method' => $order->getPaymentMethod(),
                'payment_status' => $order->getPaymentStatus()
            ];
        }, $orders);

        return $this->json($ordersArray);
    }
    
    #[Route('/orders_', name: 'order_index_all', methods: ['GET'])]
    public function indexAll(OrderRepository $orderRepository): JsonResponse
    {
        $orders = $orderRepository->findAll();

        $ordersArray = array_map(function ($order) {
            return [
                'id' => $order->getId(),
                'total_price' => $order->getTotalPrice(),
                'creation_date' => $order->getCreationDate(),
                'shipping_address' => $order->getShippingAdress(), // Change this line
                'shipping_city' => $order->getShippingCity(),
                'payment_method' => $order->getPaymentMethod(),
                'payment_status' => $order->getPaymentStatus(),
                'user' => $order->getUser()->getUsername() // assuming User entity has getUsername method
            ];
        }, $orders);

        return $this->json($ordersArray);
    }

    
    #[Route('/orders/{order_id}', name: 'order_show', methods: ['GET'])]
    public function show($order_id, Request $request, JWTEncoderInterface $jwtEncoder, UserRepository $userRepository, OrderRepository $orderRepository): JsonResponse
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

        $orderArray = [
            'id' => $order->getId(),
            'total_price' => $order->getTotalPrice(),
            'creation_date' => $order->getCreationDate(),
            'shipping_address' => $order->getShippingAdress(),
            'shipping_city' => $order->getShippingCity(),
            'payment_method' => $order->getPaymentMethod(),
            'payment_status' => $order->getPaymentStatus()
        ];

        return $this->json($orderArray);
    }

   
    #[Route('/orders_/{id}', name: 'order_show', methods: ['GET'])]
    public function show2(int $id): JsonResponse
    {
        $order = $this->orderRepository->find($id);

        if (!$order) {
            throw $this->createNotFoundException('No order found for id '.$id);
        }

        $orderDetails = [
            'id' => $order->getId(),
            'total_price' => $order->getTotalPrice(),
            'creationDate' => $order->getCreationDate(),
            'shipping_adress' => $order->getShippingAdress(),
            'shipping_city' => $order->getShippingCity(),
            'shipping_state' => $order->getShippingState(),
            'shpping_postal_code' => $order->getShppingPostalCode(),
            'shipping_country' => $order->getShippingCountry(),
            'payment_method' => $order->getPaymentMethod(),
            'payment_status' => $order->getPaymentStatus(),
            'user_id' => $order->getUser()->getId(),
        ];

        return new JsonResponse($orderDetails);
    }



    #[Route('/orders_/{id}', name: 'order_update', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $order = $entityManager->getRepository(Order::class)->find($id);

        if (!$order) {
            throw $this->createNotFoundException('No order found for id '.$id);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['total_price'])) {
            $order->setTotalPrice($data['total_price']);
        }
        if (isset($data['shipping_adress'])) {
            $order->setShippingAdress($data['shipping_adress']);
        }
        if (isset($data['shipping_city'])) {
            $order->setShippingCity($data['shipping_city']);
        }
        // Add similar blocks for other properties you want to update...

        $entityManager->flush();

        return $this->json(['status' => 'Order updated']);
    }

    
    #[Route('/orders_/{id}', name: 'order_delete', methods: ['DELETE'])]
    public function delete2(int $id): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $order = $entityManager->getRepository(Order::class)->find($id);

        if (!$order) {
            throw $this->createNotFoundException('No order found for id '.$id);
        }

        $entityManager->remove($order);
        $entityManager->flush();

        return $this->json(['status' => 'Order deleted'], Response::HTTP_NO_CONTENT);
    }


 
    #[Route('/orders', name: 'order_create', methods: ['POST'])]
    public function create(Request $request, JWTEncoderInterface $jwtEncoder, UserRepository $userRepository, EntityManagerInterface $entityManager): JsonResponse
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

        $order = new Order();
        $order->setUser($user);

        // Set creation date and total price
        $order->setCreationDate(new \DateTimeImmutable());
        $order->setTotalPrice(0);

        // Get data from the request body
        $data = json_decode($request->getContent(), true);

        // Set shipping and payment details from request
        $order->setShippingAdress($data['shipping_address']);
        $order->setShippingCity($data['shipping_city']);
        $order->setShippingState($data['shipping_state']);
        $order->setShppingPostalCode($data['shipping_postal_code']);
        $order->setShippingCountry($data['shipping_country']);
        $order->setPaymentMethod($data['payment_method']);
        $order->setPaymentStatus($data['payment_status']);

        $entityManager->persist($order);
        $entityManager->flush();

        return $this->json(['status' => 'Order created'], Response::HTTP_CREATED);
    }

    #[Route('/orders/{order_id}', name: 'order_delete', methods: ['DELETE'])]
    public function delete($order_id, Request $request, JWTEncoderInterface $jwtEncoder, UserRepository $userRepository, OrderRepository $orderRepository, EntityManagerInterface $entityManager): JsonResponse
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
    
        $entityManager->remove($order);
        $entityManager->flush();
    
        return $this->json(['status' => 'Order deleted'], Response::HTTP_NO_CONTENT);
    }
}
