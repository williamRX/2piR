# ProductController

## Routes

### 1. Lister tous les produits (Vue HTML)
- **Endpoint** : `/product`
- **Méthode** : GET
- **Description** : Affiche tous les produits dans une vue HTML en utilisant un template Twig.
- **Réponse** : Rendu du template `product/index.html.twig` avec une liste de produits.

### 2. Lister tous les produits (Format JSON)
- **Endpoint** : `/products`
- **Méthode** : GET
- **Description** : Retourne une liste JSON de tous les produits incluant des attributs détaillés.
- **Réponse** : Tableau JSON des produits, chacun avec des attributs détaillés.

### 3. Créer un nouveau produit (Formulaire HTML)
- **Endpoint** : `/product/new`
- **Méthode** : GET, POST
- **Description** : Fournit un formulaire pour créer un nouveau produit ; traite la soumission du formulaire pour créer un produit si l'utilisateur est vérifié comme administrateur.
- **Réponse** :
  - GET : Rendu de la vue du formulaire.
  - POST : Redirection vers la liste des produits si réussi ; retourne une erreur JSON si non autorisé.

### 4. Créer un nouveau produit (JSON)
- **Endpoint** : `/product/create`
- **Méthode** : POST
- **Description** : Crée un nouveau produit à partir des données JSON fournies si le demandeur a des droits d'administrateur.
- **Réponse** : Redirection pour afficher les détails du produit ou retourne un message d'erreur au format JSON.

### 5. Afficher les détails d'un produit (JSON)
- **Endpoint** : `/products/{id}`
- **Méthode** : GET
- **Description** : Retourne les détails d'un seul produit au format JSON par ID.
- **Réponse** : Objet JSON des détails du produit.

### 6. Modifier les détails d'un produit (Vue HTML)
- **Endpoint** : `/product/{id}/edit`
- **Méthode** : PUT
- **Description** : Met à jour les détails d'un produit à partir des données JSON si le demandeur a des droits d'administrateur.
- **Réponse** : Redirection pour afficher les détails du produit mis à jour ou retourne un message d'erreur au format JSON.

### 7. Supprimer un produit (Redirection HTML)
- **Endpoint** : `/product/{id}/delete`
- **Méthode** : DELETE
- **Description** : Supprime un produit par ID si le demandeur a des droits d'administrateur.
- **Réponse** : Redirection vers la liste des produits ou retourne un message d'erreur au format JSON.

### 8. Supprimer un produit (JSON)
- **Endpoint** : `/products/{id}`
- **Méthode** : DELETE
- **Description** : Supprime un produit par ID, renvoyant un message de succès au format JSON si le demandeur a des droits d'administrateur.
- **Réponse** : Objet JSON indiquant le succès ou l'échec de la suppression.

### 9. Mettre à jour les détails d'un produit (JSON)
- **Endpoint** : `/products/{id}`
- **Méthode** : PUT
- **Description** : Met à jour les détails d'un produit à partir des données JSON si le demandeur a des droits d'administrateur.
- **Réponse** : Objet JSON indiquant le succès ou l'échec de la mise à jour.

### 10. Lister les produits par catégorie
- **Endpoint** : `/product_cat/{id}`
- **Méthode** : GET
- **Description** : Liste tous les produits pour une catégorie spécifique.
- **Réponse** : Tableau JSON des produits de la catégorie spécifiée ou un message d'erreur si la catégorie n'est pas trouvée.

