# UserRepository

## Description
The `UserRepository` handles all database interactions related to the `User` entity. It extends `ServiceEntityRepository`, providing built-in methods for database access and custom functionalities tailored to the application's needs regarding user management.

## Configuration
The repository is initialized with dependencies on `ManagerRegistry` and `EntityManagerInterface` to facilitate database operations:

```php
public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
{
    parent::__construct($registry, User::class);
    $this->entityManager = $entityManager;
}
```