<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\StripeClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;


class PaymentController extends AbstractController
{

    #[Route('/create-stripe-token', name: 'create_stripe_token', methods: ['POST'])]
    public function createTestToken(Request $request) {
        $data = json_decode($request->getContent(), true);

        $stripe = new \Stripe\StripeClient('sk_test_51PAtPKJBFrNBKRFjpDKxJj7valnNbKvgBym3a3lDa9AmDewT2u4yENtlePYdrzYnsnqbVMS9oNHW3hktEGCHGzgu000uSeGsYI');
        $card = $stripe->customers->createSource(
            $data['person_token'],
            ['source' => 'tok_mastercard']
        );

        return new JsonResponse(['stripeToken' => $card->id]);
    }

    #[Route('/get-customer/{customerId}', name: 'get_customer', methods: ['GET'])]
    public function getCustomer($customerId) {
        $stripe = new \Stripe\StripeClient('sk_test_51PAtPKJBFrNBKRFjpDKxJj7valnNbKvgBym3a3lDa9AmDewT2u4yENtlePYdrzYnsnqbVMS9oNHW3hktEGCHGzgu000uSeGsYI');
        $customer = $stripe->customers->retrieve($customerId);

        return new JsonResponse(['customerId' => $customer->id]);
    }

    #[Route('/list-customers', name: 'list_customers', methods: ['GET'])]
    public function listCustomers() {
        $stripe = new \Stripe\StripeClient('sk_test_51PAtPKJBFrNBKRFjpDKxJj7valnNbKvgBym3a3lDa9AmDewT2u4yENtlePYdrzYnsnqbVMS9oNHW3hktEGCHGzgu000uSeGsYI');
        $customers = $stripe->customers->all();

        $customerIds = [];
        foreach ($customers->data as $customer) {
            $customerIds[] = $customer->id;
        }

        return new JsonResponse(['customerIds' => $customerIds]);
    }

    #[Route('/create-customer_', name: 'create_customer', methods: ['POST'])]
    public function createCustomer2(Request $request) {
        $data = json_decode($request->getContent(), true);

        $stripe = new \Stripe\StripeClient('sk_test_51PAtPKJBFrNBKRFjpDKxJj7valnNbKvgBym3a3lDa9AmDewT2u4yENtlePYdrzYnsnqbVMS9oNHW3hktEGCHGzgu000uSeGsYI');
        $customer = $stripe->customers->create([
            'email' => $data['email'],
            'name' => $data['name'],
            // Add more fields as needed
        ]);

        return new JsonResponse(['customerId' => $customer->id]);
    }

    #[Route('/create-customer', name: 'create_customer', methods: ['POST'])]
    public function createCustomer(Request $request, JWTEncoderInterface $jwtEncoder, UserRepository $userRepository): JsonResponse
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

        $stripe = new \Stripe\StripeClient('sk_test_51PAtPKJBFrNBKRFjpDKxJj7valnNbKvgBym3a3lDa9AmDewT2u4yENtlePYdrzYnsnqbVMS9oNHW3hktEGCHGzgu000uSeGsYI');
        $customer = $stripe->customers->create([
            'email' => $user->getEmail(),
            'name' => $username,
            // Add more fields as needed
        ]);

        return new JsonResponse(['customerId' => $customer->id]);
    }

    #[Route('/create-person-token', name: 'create_person_token', methods: ['POST'])]
    public function createPersonToken(Request $request) {
        $data = json_decode($request->getContent(), true);

        $stripe = new \Stripe\StripeClient('sk_test_51PAtPKJBFrNBKRFjpDKxJj7valnNbKvgBym3a3lDa9AmDewT2u4yENtlePYdrzYnsnqbVMS9oNHW3hktEGCHGzgu000uSeGsYI');
        $token = $stripe->tokens->create([
            'person' => [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'relationship' => ['owner' => true],
            ],
        ]);

        return new JsonResponse(['personToken' => $token->id]);
    }

    #[Route('/payment/charge', name: 'api_payment_charge', methods: ['POST'])]
    public function apiCharge(Request $request, OrderRepository $orderRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $order = $orderRepository->find($data['orderId']);
        $customerId = $data['customerId'] ?? null;

        if (!$order) {
            return new JsonResponse(['error' => 'Order not found'], 404);
        }

        $totalAmount = $order->getTotalPrice();

        \Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        $intentParams = [
            'amount' => $totalAmount * 100,
            'currency' => 'eur',
            'payment_method_types' => ['card'],
        ];

        if ($customerId !== null) {
            $intentParams['customer'] = $customerId;
        }

        try {
            $intent = \Stripe\PaymentIntent::create($intentParams);

            // If the PaymentIntent is successful, update the payment status of the order
            if ($intent) {
                $order->setPaymentStatus('Done');
                $entityManager->persist($order);
                $entityManager->flush();
            }

            return new JsonResponse(['success' => 'Paiement effectué avec succès', 'intent' => $intent]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
        

    
}
