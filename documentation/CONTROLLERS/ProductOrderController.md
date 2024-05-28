# ProductOrderController

## Routes

### 1. Lister toutes les commandes de produits
- **Endpoint** : `/product_order`
- **Méthode** : GET
- **Description** : Retourne toutes les commandes de produits en format JSON.
- **Réponse** : Tableau JSON de toutes les commandes de produits avec des détails tels que l'ID de commande, la quantité, l'ID du produit, et le nom du produit.

### 2. Afficher les détails de commande de produits
- **Endpoint** : `/product_order/{order_id}/{user_id}`
- **Méthode** : GET
- **Description** : Affiche les détails d'une commande spécifique pour un utilisateur donné.
- **Réponse** : 
  - Si trouvé : Tableau JSON des commandes de produits.
  - Si non trouvé : Message d'erreur approprié avec le code de statut HTTP correspondant.

### 3. Supprimer une commande de produit
- **Endpoint** : `/product_order/remove/{id}`
- **Méthode** : DELETE
- **Description** : Supprime une commande de produit spécifique.
- **Réponse** : Redirection vers l'index des commandes de produits après suppression.

### 4. Créer une commande de produit à partir d'un panier
- **Endpoint** : `/product_order/create_from_cart/{cartId}/{orderId}`
- **Méthode** : POST
- **Description** : Crée une commande de produit à partir des articles d'un panier spécifié.
- **Réponse** : JSON indiquant le succès de la création avec le statut HTTP approprié.

### 5. Créer des commandes de produits à partir du panier d'un utilisateur
- **Endpoint** : `/product_order/create_from_user_cart/{userId}/{orderId}`
- **Méthode** : POST
- **Description** : Crée des commandes de produits à partir de tous les articles dans le panier d'un utilisateur donné, vide ensuite le panier.
- **Réponse** : JSON indiquant le succès de la création avec le statut HTTP approprié.

### 6. Valider un panier et créer des commandes de produits
- **Endpoint** : `/carts/validate/{order_id}`
- **Méthode** : POST
- **Description** : Valide le contenu d'un panier pour un utilisateur et une commande donnés, vérifie les stocks, crée les commandes de produits et vide le panier.
- **Réponse** :
  - En cas de succès : JSON indiquant le succès de la création avec le statut HTTP approprié.
  - En cas d'échec (par exemple, stock insuffisant) : JSON indiquant l'échec avec un message d'erreur et le statut HTTP approprié.
