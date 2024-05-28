<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CategorieRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Categorie::class);
        $this->entityManager = $entityManager;
    }

    public function add(Categorie $categorie, bool $flush = true): void
    {
        $this->entityManager->persist($categorie);
        if ($flush) {
            $this->entityManager->flush();
        }
    }
}
