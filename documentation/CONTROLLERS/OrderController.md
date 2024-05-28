# OrderController

## Routes

### 1. Lister toutes les commandes d'un utilisateur
- **Endpoint**: `/orders`
- **Méthode**: GET
- **Description**: Retourne toutes les commandes d'un utilisateur après authentification via JWT.
- **Réponses**:
  - **200 OK**: Retourne un tableau de toutes les commandes de l'utilisateur.
  - **401 Unauthorized**: Si le token JWT est invalide.
  - **404 Not Found**: Si l'utilisateur n'est pas trouvé.

### 2. Lister toutes les commandes
- **Endpoint**: `/orders_`
- **Méthode**: GET
- **Description**: Retourne toutes les commandes dans la base de données, incluant les informations de l'utilisateur pour chaque commande.
- **Réponses**:
  - **200 OK**: Retourne un tableau contenant toutes les commandes.

### 3. Afficher une commande spécifique
- **Endpoint**: `/orders/{order_id}`
- **Méthode**: GET
- **Description**: Affiche les détails d'une commande spécifique après authentification via JWT.
- **Paramètres**:
  - `order_id`: ID de la commande à afficher.
- **Réponses**:
  - **200 OK**: Retourne les détails de la commande.
  - **401 Unauthorized**: Si le token JWT est invalide.
  - **404 Not Found**: Si l'utilisateur ou la commande n'est pas trouvée.

### 4. Créer une commande
- **Endpoint**: `/orders`
- **Méthode**: POST
- **Description**: Crée une nouvelle commande pour un utilisateur après authentification via JWT. Prend les détails de livraison et de paiement dans le corps de la requête.
- **Réponses**:
  - **201 Created**: Retourne un message de succès avec les détails de la commande créée.
  - **401 Unauthorized**: Si le token JWT est invalide.
  - **404 Not Found**: Si l'utilisateur n'est pas trouvé.

### 5. Mettre à jour une commande
- **Endpoint**: `/orders_/{id}`
- **Méthode**: PUT
- **Description**: Met à jour les détails d'une commande existante. Nécessite que l'ID de la commande soit fourni dans l'URL.
- **Paramètres**:
  - `id`: ID de la commande à mettre à jour.
- **Réponses**:
  - **200 OK**: Retourne un message indiquant que la commande a été mise à jour.
  - **404 Not Found**: Si aucune commande n'est trouvée avec cet ID.

### 6. Supprimer une commande
- **Endpoint**: `/orders_/{id}`
- **Méthode**: DELETE
- **Description**: Supprime une commande existante. Nécessite que l'ID de la commande soit fourni dans l'URL.
- **Paramètres**:
  - `id`: ID de la commande à supprimer.
- **Réponses**:
  - **204 No Content**: Retourne un message indiquant que la commande a été supprimée.
  - **404 Not Found**: Si aucune commande n'est trouvée avec cet ID.
