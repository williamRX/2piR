# Entité Product

## Description
L'entité `Product` représente un produit disponible dans l'application. Elle contient des informations détaillées sur chaque produit, telles que le nom, la description, le prix, et le stock.

## Attributs

### `id`
- **Type** : int
- **Description** : Identifiant unique pour chaque produit, généré automatiquement.

### `name`
- **Type** : string
- **Longueur** : 255 caractères
- **Description** : Nom du produit.

### `description`
- **Type** : string
- **Longueur** : 255 caractères
- **Description** : Description détaillée du produit.

### `photo`
- **Type** : string
- **Longueur** : 255 caractères
- **Description** : Chemin d'accès ou URL vers la photo du produit.

### `price`
- **Type** : decimal (precision: 10, scale: 2)
- **Description** : Prix du produit en unités monétaires.

### `stock_quantity`
- **Type** : int
- **Description** : Quantité du produit disponible en stock.

### `created_At`
- **Type** : datetime_immutable
- **Description** : Date et heure de la création du produit.

### `categorie`
- **Relation** : ManyToOne
- **Cible** : `Categorie`
- **Description** : Catégorie à laquelle appartient le produit.

## Méthodes

### Getters et Setters pour chaque attribut
Les méthodes suivantes permettent de récupérer ou de modifier les attributs de l'entité :

```php
public function getId(): ?int { ... }
public function getName(): ?string { ... }
public function setName(string $name): self { ... }
public function getDescription(): ?string { ... }
public function setDescription(string $description): self { ... }
public function getPhoto(): ?string { ... }
public function setPhoto(string $photo): self { ... }
public function getPrice(): ?float { ... }
public function setPrice(float $price): self { ... }
public function getStockQuantity(): ?int { ... }
public function setStockQuantity(int $stock_quantity): self { ... }
public function getCreatedAt(): ?\DateTimeImmutable { ... }
public function setCreatedAt(\DateTimeImmutable $created_At): self { ... }
public function getCategorie(): ?Categorie { ... }
public function setCategorie(?Categorie $categorie): self { ... }
```