# Entité ProductWishlist

## Description
L'entité `ProductWishlist` représente la liste de souhaits d'un utilisateur, associant des produits spécifiques à un utilisateur donné. Cette entité permet aux utilisateurs de sauvegarder des produits qu'ils envisagent d'acheter ultérieurement.

## Attributs

### `id`
- **Type** : int
- **Description** : Identifiant unique pour chaque entrée de la liste de souhaits, généré automatiquement.

## Relations

### `user`
- **Type** : User
- **Relation** : ManyToOne
- **Description** : L'utilisateur auquel appartient cette liste de souhaits.
- **JoinColumn** : `user_id` - clé étrangère référençant l'ID de l'utilisateur.

### `product`
- **Type** : Product
- **Relation** : ManyToOne
- **Description** : Le produit enregistré dans la liste de souhaits.
- **JoinColumn** : `product_id` - clé étrangère référençant l'ID du produit.

## Méthodes

### Getters et Setters pour chaque attribut

```php
public function getId(): ?int { ... }
public function getUser(): ?User { ... }
public function setUser(?User $user): self { ... }
public function getProduct(): ?Product { ... }
public function setProduct(?Product $product): self { ... }
```