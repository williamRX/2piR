<?php

namespace App\Controller;


use App\Entity\Categorie;
use App\Entity\Product;
use App\Repository\CategorieRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface; 
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;


class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

  
    #[Route('/products', name: 'app_product_json', methods: ['GET'])]
    public function indexJson(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        $productsArray = array_map(function ($product) {
            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'photo' => $product->getPhoto(),
                'price' => $product->getPrice(),
                'stock_quantity' => $product->getStockQuantity(),
                'created_at' => $product->getCreatedAt(),
                'categorie' => [
                    'id' => $product->getCategorie()->getId(),
                    'name' => $product->getCategorie()->getNom(),
                ],
            ];
        }, $products);

        return $this->json($productsArray);
    }


    #[Route('/product/new', name: 'product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,JWTEncoderInterface $jwtEncoder): Response
    {
        $token = $request->headers->get('Authorization');
        $data = [];

        try {
            $data = $jwtEncoder->decode($token);
        } catch (\Exception $exception) {
            // handle exception
            return $this->json(['message' => 'Invalid token'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $roles = $data['roles'];
        if($roles[0] === "ROLE_ADMIN"){
        $product = new Product();
        $form = $this->createFormBuilder($product)
            ->add('name')
            ->add('description')
            ->add('photo')
            ->add('price')
            ->add('stock_quantity')
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => function(Categorie $categorie) {
                    return sprintf('%s - %s', $categorie->getNom(), $categorie->getDescription());
                },
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_product');
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    else {
        return $this->json(['message' => 'Not admin'], JsonResponse::HTTP_UNAUTHORIZED);
    }
    }



    #[Route('/product/create', name: 'app_product_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager,JWTEncoderInterface $jwtEncoder): Response
    {
        $token = $request->headers->get('Authorization');
        $data = [];

        try {
            $data = $jwtEncoder->decode($token);
        } catch (\Exception $exception) {
            // handle exception
            return $this->json(['message' => 'Invalid token'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $roles = $data['roles'];
        if($roles[0] === "ROLE_ADMIN"){
        $data = json_decode($request->getContent(), true);

        $product = new Product();
        $product->setName($data['name']);
        $product->setDescription($data['description']);
        $product->setPhoto($data['photo']);
        $product->setPrice($data['price']);
        $product->setStockQuantity($data['stock_quantity']);
        $product->setCreatedAt(new \DateTimeImmutable());

        
     
        $categorie = $entityManager->getRepository(Categorie::class)->findOneBy(['nom' => $data['categorie']]);
        $product->setCategorie($categorie);


        $entityManager->persist($product);
        $entityManager->flush();

        return $this->redirectToRoute('app_product_show', ['id' => $product->getId()]);
    }
    else {
        return $this->json(['message' => 'Not admin'], JsonResponse::HTTP_UNAUTHORIZED);
    }
    }

    #[Route('/products', name: 'app_product_create_json', methods: ['POST'])]
    public function createJson(Request $request, EntityManagerInterface $entityManager,JWTEncoderInterface $jwtEncoder): Response
    {

        
        $data = json_decode($request->getContent(), true);

        $product = new Product();
        $product->setName($data['name']);
        $product->setDescription($data['description']);
        $product->setPhoto($data['photo']);
        $product->setPrice($data['price']);
        $product->setStockQuantity($data['stock_quantity']);
        $product->setCreatedAt(new \DateTimeImmutable());

        $categorie = $entityManager->getRepository(Categorie::class)->findOneBy(['nom' => $data['categorie']]);
        $product->setCategorie($categorie);

        $entityManager->persist($product);
        $entityManager->flush();

        return $this->json([
            'id' => $product->getId(),
        ]);
    }

    

  
    #[Route('/products/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): JsonResponse
    {
        
        return $this->json([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'photo' => $product->getPhoto(),
            'price' => $product->getPrice(),
            'stock_quantity' => $product->getStockQuantity(),
            'categorie' => $product->getCategorie()->getNom(),
            // Add more fields as needed...
        ]);
    }

    
 
    #[Route('/product/{id}/edit', name: 'app_product_edit', methods: ['PUT'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager,JWTEncoderInterface $jwtEncoder): Response
    {
        $token = $request->headers->get('Authorization');
        $data = [];

        try {
            $data = $jwtEncoder->decode($token);
        } catch (\Exception $exception) {
            // handle exception
            return $this->json(['message' => 'Invalid token'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $roles = $data['roles'];
        if($roles[0] === "ROLE_ADMIN"){
        $data = json_decode($request->getContent(), true);

        if (isset($data['name'])) {
            $product->setName($data['name']);
        }

        if (isset($data['description'])) {
            $product->setDescription($data['description']);
        }

        if (isset($data['photo'])) {
            $product->setPhoto($data['photo']);
        }

        if (isset($data['price'])) {
            $product->setPrice($data['price']);
        }

        if (isset($data['stock_quantity'])) {
            $product->setStockQuantity($data['stock_quantity']);
        }

        if (isset($data['categorie'])) {
            $categorie = $entityManager->getRepository(Categorie::class)->findOneBy(['nom' => $data['categorie']]);
            $product->setCategorie($categorie);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_product_show', ['id' => $product->getId()]);
    }
    else {
        return $this->json(['message' => 'Not admin'], JsonResponse::HTTP_UNAUTHORIZED);
    }
    }


   
    #[Route('/product/{id}/delete', name: 'app_product_delete', methods: ['DELETE'])]
    public function delete(Request $request,Product $product, EntityManagerInterface $entityManager,JWTEncoderInterface $jwtEncoder): Response
    {
        $token = $request->headers->get('Authorization');
        $data = [];

        try {
            $data = $jwtEncoder->decode($token);
        } catch (\Exception $exception) {
            // handle exception
            return $this->json(['message' => 'Invalid token'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $roles = $data['roles'];
        if($roles[0] === "ROLE_ADMIN"){
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('app_product');
    }
    else {
        return $this->json(['message' => 'Not admin'], JsonResponse::HTTP_UNAUTHORIZED);
    }
    }

    #[Route('/products/{id}', name: 'app_product_delete_json', methods: ['DELETE'])]
    public function deleteJson(Request $request,Product $product, EntityManagerInterface $entityManager,JWTEncoderInterface $jwtEncoder): Response
    {
        $token = $request->headers->get('Authorization');
        $data = [];

        try {
            $data = $jwtEncoder->decode($token);
        } catch (\Exception $exception) {
            // handle exception
            return $this->json(['message' => 'Invalid token'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $roles = $data['roles'];
        if($roles[0] === "ROLE_ADMIN"){
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->json([
            'message' => 'Product deleted successfully',
        ]);
    }
    else {
        return $this->json(['message' => 'Not admin'], JsonResponse::HTTP_UNAUTHORIZED);
    }
    }

    #[Route('/products/{id}', name: 'app_product_update_json', methods: ['PUT'])]
    public function updateJson(Request $request, Product $product, EntityManagerInterface $entityManager,JWTEncoderInterface $jwtEncoder): Response
    {
        $token = $request->headers->get('Authorization');
        $data = [];

        try {
            $data = $jwtEncoder->decode($token);
        } catch (\Exception $exception) {
            // handle exception
            return $this->json(['message' => 'Invalid token'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $roles = $data['roles'];
        if($roles[0] === "ROLE_ADMIN"){
        $data = json_decode($request->getContent(), true);

        if (isset($data['name'])) {
            $product->setName($data['name']);
        }
        if (isset($data['description'])) {
            $product->setDescription($data['description']);
        }
        if (isset($data['photo'])) {
            $product->setPhoto($data['photo']);
        }
        if (isset($data['price'])) {
            $product->setPrice($data['price']);
        }
        if (isset($data['stock_quantity'])) {
            $product->setStockQuantity($data['stock_quantity']);
        }
        if (isset($data['categorie'])) {
            $categorie = $entityManager->getRepository(Categorie::class)->findOneBy(['nom' => $data['categorie']]);
            $product->setCategorie($categorie);
        }

        $entityManager->persist($product);
        $entityManager->flush();

        return $this->json([
            'message' => 'Product updated successfully',
        ]);
    }
    else {
        return $this->json(['message' => 'Not admin'], JsonResponse::HTTP_UNAUTHORIZED);
    }
    }
    #[Route('/product_cat/{id}', name: 'product_by_category')]
      
    public function productByCategory(int $id, ProductRepository $productRepository, CategorieRepository $categorieRepository): Response
    {
        $categorie = $categorieRepository->find($id);
    
        if (!$categorie) {
            return $this->json([
                'error' => 'Categorie not found',
            ], 404);
        }
    
        $products = $productRepository->findBy(['categorie' => $categorie]);
    
        return $this->json($products);
    }

}