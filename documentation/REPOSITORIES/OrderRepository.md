# OrderRepository

## Description
Le `OrderRepository` est responsable de la gestion et des opérations de récupération des données pour l'entité `Order`. Ce repository permet d'effectuer des requêtes complexes et personnalisées en lien avec les commandes dans l'application.

## Méthodes

### Méthodes Héritées
Grâce à l'extension de `ServiceEntityRepository`, `OrderRepository` hérite de plusieurs méthodes pour effectuer des opérations CRUD (Create, Read, Update, Delete) sur les entités `Order` :

- `find($id, $lockMode = null, $lockVersion = null)` : Retourne une commande par son identifiant.
- `findOneBy(array $criteria, array $orderBy = null)` : Retourne une seule commande basée sur des critères spécifiques.
- `findAll()` : Retourne toutes les commandes.
- `findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)` : Retourne des commandes basées sur des critères spécifiques.

### Méthode Personnalisée

#### `findByDateRange(DateTime $start, DateTime $end): array`
- **Description** : Retourne toutes les commandes créées dans une plage de dates spécifiée.
- **Paramètres** :
  - `DateTime $start` : Date de début de la plage.
  - `DateTime $end` : Date de fin de la plage.
- **Retour** : Un tableau des commandes qui correspondent aux critères de date.
- **Exemple d'usage** :

```php
$startDate = new \DateTime('2021-01-01');
$endDate = new \DateTime('2021-01-31');
$orders = $orderRepository->findByDateRange($startDate, $endDate);
```