# ProductRepository

## Description
The `ProductRepository` serves as the data access layer for managing `Product` entities within the database. Extending `ServiceEntityRepository`, it provides advanced methods to handle database operations efficiently.

## Methods

### Inherited Methods
By inheriting `ServiceEntityRepository`, the `ProductRepository` gains several useful methods that facilitate common database operations:

- `find($id, $lockMode = null, $lockVersion = null)`: Retrieves a single `Product` entity by its ID.
- `findOneBy(array $criteria, array $orderBy = null)`: Fetches a single `Product` based on specific criteria and order.
- `findAll()`: Returns all `Product` entities in the database.
- `findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)`: Finds `Product` entities based on criteria, with support for ordering, limiting, and offsetting results.

## Configuration
The repository is configured through its constructor, which requires a `ManagerRegistry` instance to access the database:

```php
public function __construct(ManagerRegistry $registry)
{
    parent::__construct($registry, Product::class);
}
```