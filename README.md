# 📦 GestionStockFLD

**GestionStockFLD** est une application web de **gestion de stock** développée en **PHP/MySQL (PDO)**, permettant de gérer produits, catégories, clients, commandes et utilisateurs avec un système d’authentification et de rôles.

---

## 🚀 Objectifs

- Gérer les **produits**, **catégories**, **clients** et **commandes**.
- Mettre en place une **authentification sécurisée** avec rôles (**admin** et **employé**).
- Offrir une interface simple et fonctionnelle pour la gestion de stock.

---

## 🛠️ Technologies

- **PHP** – Backend
- **MySQL** – Stockage des données
- **Bootstrap 5** – Interface responsive
- **HTML / CSS / JavaScript** – Frontend

---

## 📂 Structure du projet

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

## 🔑 Fonctionnalités

### **Authentification**
- Connexion sécurisée (mot de passe haché)
- Inscription avec validation par l’administrateur
- Système de rôles : **admin** et **employé**

### **Gestion des utilisateurs**
- Création, suppression et affichage des utilisateurs
- Gestion des rôles et statuts

### **Gestion des produits**
- CRUD complet
- Upload sécurisé d’images (pas encore implémenté !)
- Association à une catégorie

### **Gestion des catégories**
- Ajouter, modifier et supprimer des catégories

### **Gestion des clients**
- CRUD complet
- Upload de photo ((pas encore implémenté !))
- Recherche par nom, email ou téléphone

### **Gestion des commandes**
- Association d’une commande à un client
- Sélection de produits avec quantités
- Mise à jour automatique du stock
- Consultation détaillée des commandes

---

## 🗄️ Base de données

Tables principales :
1. **utilisateur** (id, nom, email, mot_de_passe, rôle, statut)
2. **produit** (id, nom, prix, stock, image, idCategorie)
3. **categorie** (id, nom)
4. **client** (id, nom, email, téléphone, photo)
5. **commande** (id, idClient, dateCommande)
6. **commande_produit** (idCommande, idProduit, quantite)

Créer la base :
```bash
mysql -u root -p -e "CREATE DATABASE gestionStockFLD;"
mysql -u root -p gestionStockFLD < flddatabse.sql
```

---

## ⚙️ Installation

1. **Cloner le projet**
```bash
git clone https://github.com/wahabsoumare/Gestion-Commande.git
```

2. **Configurer la connexion à la BDD** dans `includes/db.php` :
```php
$host = 'localhost';
$dbname = 'gestionStockFLD';
$username = 'root';
$password = '';
```

3. **Lancer le serveur PHP**
```bash
php -S localhost:8000
```
Puis accéder à : [http://localhost:8000](http://localhost:8000)

---

## 👥 Comptes de test

**Admin**  
- Email : `wahab@email.com`  
- Mot de passe : `wahab123`

**Employé**  
- Email : `pathe@email.com`  
- Mot de passe : `pathe123`

---

## 📜 Licence

Projet distribué sous **licence académique** :  
- **Autorisé** : utilisation/modification pour projets éducatifs ou personnels, partage à des fins pédagogiques.  
- **Interdit** : usage commercial, redistribution sans mention de l’auteur.  

© 2025 - Abdoul Wahab Soumare - Projet académique
