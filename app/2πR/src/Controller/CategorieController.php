<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CategorieController extends AbstractController
{
    private $categorieRepository;
    private $serializer;
    private $validator;

    public function __construct(CategorieRepository $categorieRepository, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->categorieRepository = $categorieRepository;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    #[Route('/categories', name: 'categorie_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $categories = $this->categorieRepository->findAll();
        return $this->json($categories);
    }

    #[Route('/categories/{id}', name: 'categorie_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $categorie = $this->categorieRepository->find($id);
        if (!$categorie) {
            return $this->json(['message' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }
        return $this->json($categorie);
    }

    #[Route('/categories', name: 'categorie_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $categorieData = $this->serializer->deserialize($request->getContent(), Categorie::class, 'json');
        $errors = $this->validator->validate($categorieData);
    
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }
    
        $this->categorieRepository->add($categorieData);
        return $this->json(['status' => 'Category created'], Response::HTTP_CREATED);
    }
    

    #[Route('/categories/{id}', name: 'categorie_update', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        return $this->json(['status' => 'Category updated']);
    }

    #[Route('/categories/{id}', name: 'categorie_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        return $this->json(['status' => 'Category deleted'], Response::HTTP_NO_CONTENT);
    }
}
