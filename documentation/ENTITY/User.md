# Entité User

## Description
L'entité `User` représente un utilisateur de l'application. Elle stocke les informations d'identification, les détails personnels de l'utilisateur, ainsi que ses relations avec d'autres entités comme les paniers de produits, les listes de souhaits et les commandes.

## Attributs

### `id`
- **Type** : int
- **Description** : Identifiant unique pour chaque utilisateur, généré automatiquement.

### `username`
- **Type** : string
- **Longueur** : 255 caractères
- **Description** : Nom d'utilisateur, utilisé pour l'identification lors de la connexion.

### `password`
- **Type** : string
- **Longueur** : 255 caractères
- **Description** : Mot de passe de l'utilisateur, stocké de manière sécurisée.

### `email`
- **Type** : string
- **Longueur** : 255 caractères
- **Description** : Adresse email de l'utilisateur.

### `firstname`
- **Type** : string
- **Longueur** : 255 caractères
- **Description** : Prénom de l'utilisateur.

### `lastname`
- **Type** : string
- **Longueur** : 255 caractères
- **Description** : Nom de famille de l'utilisateur.

### `created_at`
- **Type** : DateTimeImmutable
- **Description** : Date et heure de la création du compte utilisateur.

## Relations

### `productCarts`
- **Relation** : OneToMany
- **Cible** : `ProductCart`
- **Description** : Les paniers de produits associés à cet utilisateur.

### `orders`
- **Relation** : OneToMany
- **Cible** : `Order`
- **Description** : Les commandes passées par cet utilisateur.

### `productWishlists`
- **Relation** : OneToMany
- **Cible** : `ProductWishlist`
- **Description** : Les listes de souhaits créées par cet utilisateur.

## Méthodes

### Getters et Setters

```php
public function getId(): ?int { ... }
public function getUsername(): ?string { ... }
public function setUsername(string $username): self { ... }
public function getPassword(): ?string { ... }
public function setPassword(string $password): self { ... }
public function getEmail(): ?string { ... }
public function setEmail(string $email): self { ... }
public function getFirstname(): ?string { ... }
public function setFirstname(string $firstname): self { ... }
public function getLastname(): ?string { ... }
public function setLastname(string $lastname): self { ... }
public function getCreatedAt(): ?\DateTimeImmutable { ... }
public function setCreatedAt(\DateTimeImmutable $created_at): self { ... }
public function getProductCarts(): Collection { ... }
public function getOrders(): Collection { ... }
public function getProductWishlists(): Collection { ... }
public function addProductCart(ProductCart $productCart): self { ... }
public function removeProductCart(ProductCart $productCart): self { ... }
public function addOrder(Order $order): self { ... }
public function removeOrder(Order $order): self { ... }
```