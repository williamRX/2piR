# ProductCartController

## Routes

### 1. Obtenir les produits dans le panier d'un utilisateur
- **Endpoint**: `/carts`
- **Méthode**: GET
- **Description**: Retourne les produits dans le panier de l'utilisateur authentifié.
- **Réponses**:
  - **200 OK**: Liste des produits dans le panier.
  - **401 Unauthorized**: Si le token JWT est invalide.
  - **404 Not Found**: Si l'utilisateur n'est pas trouvé.

### 2. Ajouter un produit au panier
- **Endpoint**: `/carts/{product_id}`
- **Méthode**: POST
- **Description**: Ajoute un produit spécifié au panier de l'utilisateur authentifié.
- **Paramètres**:
  - `product_id`: ID du produit à ajouter.
- **Réponses**:
  - **200 OK**: Produit ajouté avec succès au panier.
  - **401 Unauthorized**: Si le token JWT est invalide.
  - **404 Not Found**: Si l'utilisateur ou le produit n'est pas trouvé.

### 3. Retirer un produit du panier
- **Endpoint**: `/carts/{product_id}`
- **Méthode**: DELETE
- **Description**: Retire un produit spécifié du panier de l'utilisateur authentifié.
- **Paramètres**:
  - `product_id`: ID du produit à retirer.
- **Réponses**:
  - **200 OK**: Produit retiré avec succès du panier.
  - **401 Unauthorized**: Si le token JWT est invalide.
  - **404 Not Found**: Si l'utilisateur ou le produit n'est pas trouvé dans le panier.

### 4. Réduire la quantité d'un produit dans le panier
- **Endpoint**: `/carts/{product_id}`
- **Méthode**: PUT
- **Description**: Réduit la quantité d'un produit spécifié dans le panier de l'utilisateur authentifié.
- **Paramètres**:
  - `product_id`: ID du produit dont la quantité doit être réduite.
- **Réponses**:
  - **200 OK**: Quantité du produit réduite avec succès.
  - **401 Unauthorized**: Si le token JWT est invalide.
  - **404 Not Found**: Si le produit n'est pas trouvé dans le panier de l'utilisateur.

### 5. Lister tous les produits dans tous les paniers
- **Endpoint**: `/product_cart`
- **Méthode**: GET
- **Description**: Liste tous les produits dans tous les paniers.
- **Réponses**:
  - **200 OK**: Liste de tous les produits dans tous les paniers.

### 6. Afficher les produits d'un panier spécifique
- **Endpoint**: `/product_cart/{id}`
- **Méthode**: GET
- **Description**: Affiche les produits dans le panier d'un utilisateur spécifié.
- **Paramètres**:
  - `id`: ID de l'utilisateur dont le panier est à afficher.
- **Réponses**:
  - **200 OK**: Affiche les produits dans le panier de l'utilisateur.

### 7. Ajouter un produit au panier
- **Endpoint**: `/product_cart/{id}`
- **Méthode**: POST
- **Description**: Ajoute un produit au panier.
- **Paramètres**:
  - `id`: ID du produit à ajouter au panier.
- **Réponses**:
  - **302 Found**: Redirige vers la liste des paniers après ajout.

### 8. Retirer un produit du panier
- **Endpoint**: `/product_cart/{id}`
- **Méthode**: DELETE
- **Description**: Retire un produit du panier.
- **Paramètres**:
  - `id`: ID du produit à retirer du panier.
- **Réponses**:
  - **302 Found**: Redirige vers la liste des paniers après retrait.
