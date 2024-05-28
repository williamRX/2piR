# Entité ProductOrder

## Description
L'entité `ProductOrder` représente une ligne de commande associant un produit à une commande spécifique. Elle permet de gérer la quantité de chaque produit commandé dans une commande donnée.

## Attributs

### `id`
- **Type** : int
- **Description** : Identifiant unique pour chaque ligne de commande, généré automatiquement.

### `quantity`
- **Type** : int
- **Description** : Quantité du produit dans la commande.

## Relations

### `order`
- **Type** : Order
- **Relation** : ManyToOne
- **Description** : La commande à laquelle cette ligne de commande est associée.
- **JoinColumn** : `order_id` - clé étrangère référençant l'ID de la commande.

### `product`
- **Type** : Product
- **Relation** : ManyToOne
- **Description** : Le produit concerné par cette ligne de commande.
- **JoinColumn** : `product_id` - clé étrangère référençant l'ID du produit.

## Méthodes

### Accesseurs et mutateurs pour chaque attribut

```php
public function getId(): ?int { ... }
public function getQuantity(): ?int { ... }
public function setQuantity(int $quantity): self { ... }
public function getOrder(): ?Order { ... }
public function setOrder(?Order $order): self { ... }
public function getProduct(): ?Product { ... }
public function setProduct(?Product $product): self { ... }
```