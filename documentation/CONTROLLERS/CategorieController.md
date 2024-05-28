# CategorieController

## Routes

### 1. Lister toutes les catégories
- **Endpoint**: `/categories`
- **Méthode**: GET
- **Description**: Retourne toutes les catégories enregistrées.
- **Réponses**:
  - **200 OK**: Retourne un tableau JSON des catégories.

### 2. Afficher une catégorie spécifique
- **Endpoint**: `/categories/{id}`
- **Méthode**: GET
- **Description**: Retourne les détails d'une catégorie spécifique.
- **Paramètres**:
  - `id`: ID de la catégorie à afficher.
- **Réponses**:
  - **200 OK**: Retourne un objet JSON de la catégorie.
  - **404 Not Found**: Si aucune catégorie n'est trouvée avec l'ID spécifié, retourne un message d'erreur.

### 3. Créer une nouvelle catégorie
- **Endpoint**: `/categories`
- **Méthode**: POST
- **Description**: Crée une nouvelle catégorie avec les données fournies.
- **Corps de la requête**: JSON contenant les données de la nouvelle catégorie.
- **Réponses**:
  - **201 Created**: Retourne un message de succès si la catégorie est créée.
  - **400 Bad Request**: Retourne une liste d'erreurs de validation si les données ne sont pas valides.

### 4. Mettre à jour une catégorie
- **Endpoint**: `/categories/{id}`
- **Méthode**: PUT
- **Description**: Met à jour les détails d'une catégorie existante.
- **Paramètres**:
  - `id`: ID de la catégorie à mettre à jour.
- **Corps de la requête**: JSON contenant les nouvelles données de la catégorie.
- **Réponses**:
  - **200 OK**: Retourne un message de succès si la catégorie est mise à jour.
  - **400 Bad Request**: Si les données fournies ne sont pas valides.

### 5. Supprimer une catégorie
- **Endpoint**: `/categories/{id}`
- **Méthode**: DELETE
- **Description**: Supprime une catégorie spécifique.
- **Paramètres**:
  - `id`: ID de la catégorie à supprimer.
- **Réponses**:
  - **204 No Content**: Retourne un message de succès si la catégorie est supprimée.
  - **404 Not Found**: Si aucune catégorie n'est trouvée avec l'ID spécifié.
