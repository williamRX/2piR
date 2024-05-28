# Entité Order

## Description
L'entité `Order` représente une commande passée par un utilisateur. Elle contient toutes les informations nécessaires pour traiter une commande, incluant les détails de paiement et de livraison.

## Attributs

### `id`
- **Type** : int
- **Description** : Identifiant unique pour chaque commande, généré automatiquement.

### `total_price`
- **Type** : int
- **Description** : Le prix total de la commande.

### `creationDate`
- **Type** : DateTimeImmutable
- **Description** : Date de création de la commande.

### `shipping_address`
- **Type** : string
- **Longueur** : 255 caractères
- **Description** : Adresse de livraison pour la commande.

### `shipping_city`
- **Type** : string
- **Longueur** : 255 caractères
- **Description** : Ville de livraison pour la commande.

### `shipping_state`
- **Type** : string
- **Longueur** : 255 caractères
- **Description** : État ou région de livraison pour la commande.

### `shipping_postal_code`
- **Type** : string
- **Longueur** : 255 caractères
- **Description** : Code postal de livraison pour la commande.

### `shipping_country`
- **Type** : string
- **Longueur** : 255 caractères
- **Description** : Pays de livraison pour la commande.

### `payment_method`
- **Type** : string
- **Longueur** : 255 caractères
- **Description** : Méthode de paiement utilisée pour la commande.

### `payment_status`
- **Type** : string
- **Longueur** : 255 caractères
- **Description** : Statut du paiement pour la commande.

### `user`
- **Relation** : ManyToOne
- **Cible** : `User`
- **Description** : Utilisateur qui a passé la commande.

## Méthodes

### Accesseurs et mutateurs pour chaque attribut

Chaque champ dispose d'un accesseur et d'un mutateur, permettant la récupération et la modification de ses valeurs. Les méthodes suivent la convention standard de Symfony pour les entités Doctrine, permettant ainsi une intégration facile avec le système de formulaire et de persistance.

```php
public function getId(): ?int { ... }
public function getTotalPrice(): ?int { ... }
public function setTotalPrice(int $total_price): self { ... }
public function getCreationDate(): ?\DateTimeImmutable { ... }
public function setCreationDate(\DateTimeImmutable $creationDate): self { ... }
public function getShippingAddress(): ?string { ... }
public function setShippingAddress(string $shipping_address): self { ... }
public function getShippingCity(): ?string { ... }
public function setShippingCity(string $shipping_city): self { ... }
public function getShippingState(): ?string { ... }
public function setShippingState(string $shipping_state): self { ... }
public function getShippingPostalCode(): ?string { ... }
public function setShippingPostalCode(string $shipping_postal_code): self { ... }
public function getShippingCountry(): ?string { ... }
public function setShippingCountry(string $shipping_country): self { ... }
public function getPaymentMethod(): ?string { ... }
public function setPaymentMethod(string $payment_method): self { ... }
public function getPaymentStatus(): ?string { ... }
public function setPaymentStatus(string $payment_status): self { ... }
public function getUser(): ?User { ... }
public function setUser(User $user): self { ... }
```
