# PaymentController

## Routes

### 1. Créer un token Stripe pour les tests
- **Endpoint**: `/create-stripe-token`
- **Méthode**: POST
- **Description**: Crée un token Stripe pour les tests en utilisant des données de carte prédéfinies.
- **Réponses**:
  - **200 OK**: Retourne un token Stripe.
  - **Exemple de réponse**: `{"stripeToken": "tok_xyz"}`

### 2. Obtenir un client Stripe
- **Endpoint**: `/get-customer/{customerId}`
- **Méthode**: GET
- **Description**: Récupère les informations d'un client Stripe à partir de son ID.
- **Paramètres**:
  - `customerId`: ID du client Stripe.
- **Réponses**:
  - **200 OK**: Retourne l'ID du client.
  - **Exemple de réponse**: `{"customerId": "cus_xyz"}`

### 3. Lister tous les clients Stripe
- **Endpoint**: `/list-customers`
- **Méthode**: GET
- **Description**: Récupère tous les clients enregistrés sur Stripe.
- **Réponses**:
  - **200 OK**: Retourne une liste des ID de clients.
  - **Exemple de réponse**: `{"customerIds": ["cus_xyz", "cus_abc"]}`

### 4. Créer un client Stripe (avec authentification)
- **Endpoint**: `/create-customer`
- **Méthode**: POST
- **Description**: Crée un nouveau client Stripe en utilisant les informations de l'utilisateur authentifié.
- **Réponses**:
  - **201 Created**: Retourne l'ID du nouveau client créé.
  - **401 Unauthorized**: Si le token JWT est invalide.
  - **404 Not Found**: Si l'utilisateur n'est pas trouvé.
  - **Exemple de réponse**: `{"customerId": "cus_new_xyz"}`

### 5. Créer un token pour une personne
- **Endpoint**: `/create-person-token`
- **Méthode**: POST
- **Description**: Crée un token Stripe pour une personne avec des détails spécifiques.
- **Réponses**:
  - **200 OK**: Retourne le token créé pour la personne.
  - **Exemple de réponse**: `{"personToken": "tok_person_xyz"}`

### 6. Effectuer un paiement
- **Endpoint**: `/payment/charge`
- **Méthode**: POST
- **Description**: Effectue un paiement pour une commande spécifique, potentiellement en utilisant un client Stripe existant.
- **Réponses**:
  - **200 OK**: Paiement effectué avec succès et mise à jour du statut de paiement de la commande.
  - **400 Bad Request**: Erreur lors du paiement.
  - **404 Not Found**: Si la commande spécifiée n'est pas trouvée.
  - **Exemple de réponse**: `{"success": "Paiement effectué avec succès", "intent": {...}}`

