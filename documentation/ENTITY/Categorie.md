# Entité Categorie

## Description
L'entité `Categorie` représente une catégorie de produits dans l'application. Elle sert à regrouper les produits similaires sous une même catégorie pour une meilleure organisation.

## Attributs

### `id`
- **Type** : int
- **Description** : Identifiant unique pour chaque catégorie, généré automatiquement par la base de données.

### `nom`
- **Type** : string
- **Longueur** : 255 caractères
- **Description** : Nom de la catégorie.

### `description`
- **Type** : string (nullable)
- **Longueur** : 255 caractères
- **Description** : Description détaillée de la catégorie. Cette propriété est optionnelle.

## Relations

### `products`
- **Relation** : OneToMany
- **Cible** : `Product`
- **Inversé par** : `categorie`
- **Description** : Collection des produits appartenant à cette catégorie. Utilise une instance de `Doctrine\Common\Collections\Collection` pour gérer la collection de manière efficace.

## Méthodes

### `getId()`
- **Retour** : ?int
- **Description** : Renvoie l'ID de la catégorie.

### `getNom()`
- **Retour** : ?string
- **Description** : Renvoie le nom de la catégorie.

### `setNom(string $nom)`
- **Paramètre** : `nom` - Le nouveau nom de la catégorie.
- **Retour** : self
- **Description** : Définit le nom de la catégorie et renvoie l'instance pour permettre les chaînages de méthodes.

### `getDescription()`
- **Retour** : ?string
- **Description** : Renvoie la description de la catégorie.

### `setDescription(?string $description)`
- **Paramètre** : `description` - La nouvelle description de la catégorie.
- **Retour** : self
- **Description** : Définit la description de la catégorie et renvoie l'instance pour permettre les chaînages de méthodes.

---