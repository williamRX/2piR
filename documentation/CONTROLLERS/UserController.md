# UserController

## Routes

### 1. Lister tous les utilisateurs (Format JSON)
- **Endpoint** : `/users_`
- **Méthode** : GET
- **Description** : Retourne tous les utilisateurs enregistrés dans un format JSON détaillé, incluant les paniers de produits et les listes de souhaits.
- **Réponse** : Tableau JSON contenant les détails de chaque utilisateur.

### 2. Récupérer les informations d'un utilisateur
- **Endpoint** : `/users`
- **Méthode** : GET
- **Description** : Récupère les informations détaillées d'un utilisateur via un token JWT.
- **Réponse** : JSON contenant les informations de l'utilisateur ou un message d'erreur si le token est invalide ou l'utilisateur n'est pas trouvé.

### 3. Mettre à jour les informations d'un utilisateur
- **Endpoint** : `/users`
- **Méthode** : PUT
- **Description** : Met à jour les informations de l'utilisateur authentifié. Les modifications sont appliquées seulement si le token JWT est valide.
- **Réponse** : JSON indiquant le succès de la mise à jour ou un message d'erreur en cas de problème.

### 4. Afficher les détails d'un utilisateur spécifique
- **Endpoint** : `/user/{id}`
- **Méthode** : GET
- **Description** : Affiche les détails d'un utilisateur spécifique par son ID.
- **Réponse** : JSON contenant les détails de l'utilisateur ou un message d'erreur si l'utilisateur n'est pas trouvé.

### 5. Enregistrer un nouvel utilisateur
- **Endpoint** : `/register`
- **Méthode** : POST
- **Description** : Crée un nouvel utilisateur à partir des données fournies. Le mot de passe est hashé avant d'être enregistré.
- **Réponse** : JSON contenant les détails de l'utilisateur créé ou une liste d'erreurs de validation.

### 6. Supprimer un utilisateur
- **Endpoint** : `/user/{id}`
- **Méthode** : DELETE
- **Description** : Supprime un utilisateur par son ID.
- **Réponse** : JSON indiquant le succès de la suppression ou un message d'erreur si l'utilisateur n'est pas trouvé.

### 7. Connexion d'un utilisateur
- **Endpoint** : `/login`
- **Méthode** : POST
- **Description** : Authentifie un utilisateur et génère un token JWT si les identifiants sont valides.
- **Réponse** : JSON contenant le token JWT ou un message d'erreur en cas d'identifiants invalides.

### 8. Ajouter un produit au panier d'un utilisateur
- **Endpoint** : `/usersproducts/add/{userId}/{productId}/{quantity}`
- **Méthode** : POST
- **Description** : Ajoute un produit au panier d'un utilisateur spécifié. Si le produit existe déjà dans le panier, la quantité est augmentée.
- **Réponse** : JSON indiquant le succès de l'ajout ou un message d'erreur en cas de problème.

### 9. Retirer un produit du panier d'un utilisateur
- **Endpoint** : `/usersproducts/remove/{userId}/{productId}/{quantity}`
- **Méthode** : DELETE
- **Description** : Retire une quantité spécifiée d'un produit du panier d'un utilisateur. Si la quantité à retirer équivaut ou excède celle dans le panier, le produit est entièrement retiré.
- **Réponse** : JSON indiquant le succès de l'opération ou un message d'erreur en cas de problème.
