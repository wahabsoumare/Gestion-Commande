# 📦 GestionStockFLD

Application web de **gestion de stock** développée en **PHP/MySQL (PDO)**.

---

## 🎯 Objectif du projet
Mettre en place une application permettant de gérer :
- Les **produits**
- Les **catégories**
- Les **clients**
- Les **commandes** (avec produits et quantités)
- Les **utilisateurs** (admin et employés, avec système de validation)

---

## 🛠 Technologies utilisées
- **PHP** (PDO pour la connexion MySQL)
- **MySQL**
- **Bootstrap 5**
- **HTML / CSS / JS**

---

## 📁 Structure du projet

```bash
gestionStockFLD
├── admin                   # Validation des utilisateurs
│   ├── index.php
│   └── updateStatut.php
├── auth                    # Authentification et inscription
│   ├── attenteValidation.php
│   ├── login.php
│   ├── logout.php
│   ├── register.php
│   └── traitement_login.php
├── categories              # CRUD catégories
│   ├── addCategorie.php
│   ├── deleteCategorie.php
│   ├── formulaireModificationCategorie.php
│   ├── listeCategorie.php
│   └── updateCategorie.php
├── clients                 # CRUD clients
│   ├── addClient.php
│   ├── deleteClient.php
│   ├── formulaireClient.php
│   ├── formulaireModificationClient.php
│   ├── index.php
│   ├── listeClient.php
│   ├── medias
│   ├── searchClient.php
│   └── updateClient.php
├── commandes               # Gestion des commandes
│   ├── addCommande.php
│   ├── detailsCommande.php
│   ├── formulaireStatutCommande.php
│   ├── listeCommande.php
│   ├── updateStatutCommande.php
│   └── voirCommande.php
├── produits                # CRUD produits
│   ├── addProduit.php
│   ├── deleteProduit.php
│   ├── formulaireModificationProduit.php
│   ├── formulaireProduit.php
│   ├── index.php
│   ├── listeProduit.php
│   ├── searchProduit.php
│   └── updateProduit.php
├── utilisateurs            # Gestion des utilisateurs
│   ├── addUser.php
│   ├── deleteUser.php
│   ├── formulaireModificationUser.php
│   ├── formulaireUser.php
│   ├── index.php
│   ├── listeUser.php
│   └── searchUser.php
├── includes                # Fichiers communs
│   ├── db.php
│   ├── footer.php
│   ├── header.php
│   ├── navbar.php
│   └── redirectTo.php
├── flddatabse.sql          # Script SQL
├── index.php               # Page d'accueil
└── README.md
```
---
# 🔑 Fonctionnalités

## **Authentification**
- Login sécurisé (mot de passe haché)
- Système de rôles (**admin** et **employé**)
- Inscription avec validation par l’administrateur

## **Gestion des utilisateurs**
- Admin : création / suppression des comptes
- Liste des utilisateurs actifs avec rôle et statut

## **Gestion des produits**
- Ajouter / modifier / supprimer
- Upload sécurisé d’image
- Association à une catégorie

## **Gestion des catégories**
- Ajouter / modifier / supprimer

## **Gestion des clients**
- Ajouter / modifier / supprimer
- Upload photo
- Recherche par nom, email ou téléphone

## **Gestion des commandes**
- Associer une commande à un client
- Sélection de produits avec quantité
- Mise à jour automatique du stock
- Consultation détaillée des commandes

---

# 🗄 Base de données

Tables principales :
1. **utilisateur** (id, nom, email, mot_de_passe, rôle, statut)
2. **produit** (id, nom, prix, stock, image, idCategorie)
3. **categorie** (id, nom)
4. **client** (id, nom, email, téléphone, photo)
5. **commande** (id, idClient, dateCommande)
6. **commande_produit** (idCommande, idProduit, quantite)

Importez `flddatabse.sql` pour créer la structure complète :

```bash
mysql -u root -p gestionStockFLD < flddatabse.sql
```

---

---
# 🚀 Installation

## Cloner le projet
```bash
git clone <url-du-repo>
cd gestionStockFLD
```

Créer la base de données
```bash
mysql -u root -p -e "CREATE DATABASE gestionStockFLD;"
```

```bash
mysql -u root -p gestionStockFLD < flddatabse.sql
```

Configurer la connexion dans includes/db.php
```php
$host = 'localhost';
$dbname = 'gestionStockFLD';
$username = 'root';
$password = '';
```

Lancer le serveur
```bash
php -S localhost:8000
```
Puis accéder à : http://localhost:8000

---

---
👥 Comptes de test
Admin
Email : wahab@email.com

Mot de passe : wahab123

Employé
Email : pathe@email.com

Mot de passe : pathe123

---

---

📜 Licence
Ce projet est distribué sous une licence à usage académique uniquement.
Vous êtes autorisé à :

Utiliser et modifier ce code pour des projets éducatifs ou personnels.

Partager ce projet à des fins pédagogiques.

Vous n’êtes pas autorisé à :

Utiliser ce projet à des fins commerciales.

Redistribuer ce projet sans mention de l’auteur original.

© 2025 - Abdoul Wahab Soumare - Projet académique
---