<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, User::class);
        $this->entityManager = $entityManager;
    }

    public function add(User $user): void
    {
        if ($user->getCreatedAt() === null) {
            $user->setCreatedAt(new \DateTimeImmutable());
        }
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
    
    public function findAllUsersWithAssociations()
    {
        try {
            $query = $this->createQueryBuilder('u')
                ->leftJoin('u.productCarts', 'pc')
                ->addSelect('pc')
                ->leftJoin('u.productWishlists', 'pw')
                ->addSelect('pw')
                ->leftJoin('u.orders', 'o')
                ->addSelect('o');
        
            $result = $query->getQuery()->getResult();
            var_dump($result);
            return $result;
        } catch (\Exception $e) {
            throw new \Exception("Error executing query: " . $e->getMessage());
        }
        
    }
    
}
