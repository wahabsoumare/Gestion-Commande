-- DROP DATABASE IF EXISTS gestionStockFLD;
-- CREATE DATABASE gestionStockFLD CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE gestionStockFLD;

-- Table : utilisateur
CREATE TABLE utilisateur (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  mot_de_passe VARCHAR(255) NOT NULL,
  role ENUM('admin', 'employe') DEFAULT 'employe',
  statut BOOLEAN DEFAULT TRUE,
  image VARCHAR(255)
);

-- Table : categorie
CREATE TABLE categorie (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL
);

-- Table : produit
CREATE TABLE produit (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(255) NOT NULL,
  prix DECIMAL(10,2) NOT NULL,
  stock INT NOT NULL,
  image VARCHAR(255),
  idCategorie INT,
  FOREIGN KEY (idCategorie) REFERENCES categorie(id) ON DELETE SET NULL
);

-- Table : client
CREATE TABLE client (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  email VARCHAR(100),
  telephone VARCHAR(20),
  photo VARCHAR(255)
);

-- Table : commande
CREATE TABLE commande (
  id INT AUTO_INCREMENT PRIMARY KEY,
  idClient INT NOT NULL,
  dateCommande DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (idClient) REFERENCES client(id) ON DELETE CASCADE
);

-- Table : commande_produit (ligne de commande)
CREATE TABLE commande_produit (
  idCommande INT,
  idProduit INT,
  quantite INT NOT NULL,
  PRIMARY KEY (idCommande, idProduit),
  FOREIGN KEY (idCommande) REFERENCES commande(id) ON DELETE CASCADE,
  FOREIGN KEY (idProduit) REFERENCES produit(id) ON DELETE CASCADE
);

-- Table : inscription_attente
CREATE TABLE inscription_attente (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  mot_de_passe VARCHAR(255) NOT NULL,
  date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO utilisateur (nom, email, mot_de_passe, role, image) VALUES
('wahab', 'wahab@email.com', '$2y$10$Itlbpb8LtyySVA0EJUtAzORu/Ov6hkHMjbk1RI/Rhm0479sqFViVS', 'admin', NULL),
('pathe', 'pathe@email.com', '$2y$10$YxAfH1ZfQ5s5ir0CN.4e6.6BwIzF7rIUQF9wW8bGQCvJW4v/yUYRm', 'employe', NULL);

INSERT INTO categorie (nom) VALUES
('Informatique'),
('Électronique'),
('Vêtements'),
('Alimentaires'),
('Livres'),
('Maison & Jardin'),
('Jouets'),
('Sports & Loisirs'),
('Beauté & Santé'),
('Automobile');

INSERT INTO produit (nom, prix, stock, image, idCategorie) VALUES
('Riz blanc 5kg', 3500.00, 50, 'images/riz_blanc_5kg.jpg', 4),
('Huile d\'arachide 1L', 1200.00, 80, 'images/huile_arachide_1l.jpg', 4),
('Poisson fumé', 800.00, 100, 'images/poisson_fume.jpg', 4),
('Bissap (fleurs d\'hibiscus) séché 500g', 600.00, 60, 'images/bissap_500g.jpg', 4),
('Thé vert (gunpowder) 250g', 900.00, 70, 'images/the_vert_250g.jpg', 4),
('Mafé (pâte d\'arachide) 1kg', 1500.00, 40, 'images/pate_arachide_1kg.jpg', 4),
('Tamarin séché 300g', 400.00, 90, 'images/tamarin_300g.jpg', 4),
('Mil 1kg', 2500.00, 55, 'images/mil_1kg.jpg', 4),
('Sénégalais pain de singe (fruit du baobab)', 500.00, 30, 'images/pain_de_singe.jpg', 4),
('Poivre noir local 100g', 700.00, 45, 'images/poivre_noir_100g.jpg', 4),
('Tissu wax 6 yards', 8000.00, 20, 'images/tissu_wax.jpg', 3),
('Sandales traditionnelles en cuir', 3500.00, 15, 'images/sandales_cuir.jpg', 3),
('Bijoux en bronze de la région de Thiès', 5000.00, 10, 'images/bijoux_bronze.jpg', 9),
('Lait caillé traditionnel 1L', 900.00, 50, 'images/lait_caille_1l.jpg', 4),
('Café sénégalais moulu 250g', 1200.00, 40, 'images/cafe_senegalais.jpg', 4),
('Mobilier en bois sculpté', 25000.00, 5, 'images/mobilier_bois.jpg', 6),
('Casquette traditionnelle (mbubb)', 2000.00, 25, 'images/casquette_mbubb.jpg', 3),
('Sablier de sable décoratif', 1500.00, 12, 'images/sablier_sable.jpg', 6),
('Bougies parfumées naturelles', 1800.00, 30, 'images/bougies_parfumees.jpg', 9),
('Tapis berbère fait main', 22000.00, 8, 'images/tapis_berbere.jpg', 6);

INSERT INTO client (nom, email, telephone, photo) VALUES
('Mamadou Ndiaye', 'mamadou@email.com', '778912345', NULL),
('Aminata Diop', 'aminata@email.com', '770112233', NULL),
('Cheikh Ba', 'cheikh@email.com', '765543210', NULL),
('Fatou Sow', 'fatou@email.com', '775566778', NULL),
('Modou Fall', 'modou@email.com', '764433221', NULL),
('Seynabou Diallo', 'seynabou@email.com', '771234567', NULL),
('Ibrahima Cissé', 'ibrahima@email.com', '769876543', NULL),
('Coumba Sarr', 'coumba@email.com', '776543210', NULL),
('Abdoulaye Kane', 'abdoulaye@email.com', '778899001', NULL),
('Awa Gueye', 'awa@email.com', '770078945', NULL),
('Ousmane Faye', 'ousmane@email.com', '765501122', NULL),
('Bineta Ndiaye', 'bineta@email.com', '773344556', NULL),
('El Hadji Dione', 'elhadji@email.com', '778800112', NULL),
('Khady Ndoye', 'khady@email.com', '774455667', NULL),
('Pape Sy', 'pape@email.com', '772211334', NULL),
('Mariama Mbaye', 'mariama@email.com', '766677889', NULL),
('Babacar Diouf', 'babacar@email.com', '775599887', NULL),
('Astou Camara', 'astou@email.com', '779900112', NULL),
('Serigne Ndao', 'serigne@email.com', '768811223', NULL),
('Mame Diarra Thiam', 'mame@email.com', '771100220', NULL);