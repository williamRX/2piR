# Entité ProductCart

## Description
L'entité `ProductCart` représente le panier de produits d'un utilisateur dans l'application. Elle permet de suivre les quantités de produits sélectionnés par les utilisateurs avant la finalisation de l'achat.

## Attributs

### `id`
- **Type** : int
- **Description** : Identifiant unique pour chaque entrée du panier, généré automatiquement.

### `quantity`
- **Type** : int
- **Validation** : PositiveOrZero
- **Description** : Quantité du produit dans le panier. Doit être zéro ou positif.

### Relations

#### `user`
- **Type** : User
- **Relation** : ManyToOne
- **Description** : L'utilisateur auquel ce panier appartient. Chaque utilisateur peut avoir plusieurs entrées de panier.
- **JoinColumn** : `user_id`

#### `product`
- **Type** : Product
- **Relation** : ManyToOne
- **Description** : Le produit stocké dans le panier.
- **JoinColumn** : `product_id`

## Méthodes

### Getters et Setters pour chaque attribut

```php
public function getId(): ?int { ... }
public function getQuantity(): ?int { ... }
public function setQuantity(int $quantity): self { ... }
public function getUser(): ?User { ... }
public function setUser(?User $user): self { ... }
public function getProduct(): ?Product { ... }
public function setProduct(?Product $product): self { ... }
```