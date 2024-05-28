# CategorieRepository

## Description
Le `CategorieRepository` est responsable de l'accès aux données et des opérations spécifiques sur l'entité `Categorie`. Ce repository hérite de `ServiceEntityRepository`, fournissant des fonctionnalités avancées pour interagir avec la base de données via Doctrine.

## Méthodes

### `add(Categorie $categorie, bool $flush = true): void`
- **Description** : Ajoute une nouvelle catégorie à la base de données.
- **Paramètres** :
  - `Categorie $categorie` : L'instance de la catégorie à ajouter.
  - `bool $flush` : Un booléen indiquant si les modifications doivent être immédiatement flushées. La valeur par défaut est `true`.
- **Fonctionnement** :
  - Cette méthode persiste l'objet `Categorie` passé en paramètre dans l'EntityManager.
  - Si `flush` est `true`, elle exécute également un flush pour synchroniser immédiatement l'état de l'objet avec la base de données.

### Utilisation typique

```php
$categorie = new Categorie();
$categorie->setNom("Électronique");
$categorie->setDescription("Tous les gadgets électroniques.");
$categorieRepository->add($categorie);
```