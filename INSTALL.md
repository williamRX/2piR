# Installation du Projet

Ce guide vous fournira les instructions étape par étape pour installer et exécuter l'application sur votre machine locale en utilisant Docker et Docker Compose.

## Prérequis

Avant de commencer l'installation, assurez-vous que les logiciels suivants sont installés sur votre système :

- **Docker**: Un moteur de conteneurisation qui vous permet de lancer des applications dans des conteneurs logiciels.
- **Docker Compose**: Un outil pour définir et gérer des applications multi-conteneurs avec Docker.

### Installation de Docker

Docker peut être installé sur la plupart des systèmes d'exploitation. Suivez les instructions spécifiques à votre système d'exploitation sur le site officiel de Docker :

- [Installer Docker sur Windows](https://docs.docker.com/docker-for-windows/install/)
- [Installer Docker sur macOS](https://docs.docker.com/docker-for-mac/install/)
- [Installer Docker sur Linux](https://docs.docker.com/engine/install/)

### Installation de Docker Compose

En général, Docker Compose est installé avec Docker sur Windows et macOS, mais pour Linux, vous pourriez devoir l'installer séparément :

- [Installer Docker Compose sur Linux](https://docs.docker.com/compose/install/)

## Installation du Projet

Une fois Docker et Docker Compose installés, vous pouvez procéder à l'installation du projet.

### Cloner le dépôt

Commencez par cloner le dépôt Git de votre projet sur votre machine locale (remplacez `URL_DU_DEPOT` par l'URL de votre dépôt) :

```bash
git clone URL_DU_DEPOT
cd NOM_DU_PROJET
```

### Build le Projet

À la racine du projet, où se trouve le fichier docker-compose.yml, exécutez la commande suivante pour construire et démarrer les conteneurs :
```bash
docker compose up -d --build
```