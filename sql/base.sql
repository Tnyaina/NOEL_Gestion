CREATE DATABASE NOEL;
USE NOEL;

CREATE TABLE USER (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    mot_de_passe VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    user_type ENUM('admin', 'user') DEFAULT 'user'
);

CREATE TABLE DEPOT (
    id_depot INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    status_depot ENUM('en_attente', 'valide') DEFAULT 'en_attente',
    FOREIGN KEY (id_user) REFERENCES USER(id_user)
);

CREATE TABLE CADEAUX (
    id_cadeaux INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    categorie ENUM('fille', 'garcon', 'neutre') NOT NULL,
    prix DECIMAL(10,2) NOT NULL
);

CREATE TABLE CHOIX_CADEAUX (
    id_choix INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    id_cadeaux INT NOT NULL,
    type_enfant ENUM('fille', 'garcon') NOT NULL,
    FOREIGN KEY (id_user) REFERENCES USER(id_user),
    FOREIGN KEY (id_cadeaux) REFERENCES CADEAUX(id_cadeaux)
);


-- Ajout de la table COMMANDE
CREATE TABLE COMMANDE (
    id_commande INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    date_commande DATETIME NOT NULL,
    FOREIGN KEY (id_user) REFERENCES USER(id_user)
);

-- Ajout de la table COMMANDE_DETAILS
CREATE TABLE COMMANDE_DETAILS (
    id_detail INT PRIMARY KEY AUTO_INCREMENT,
    id_commande INT NOT NULL,
    id_cadeaux INT NOT NULL,
    FOREIGN KEY (id_commande) REFERENCES COMMANDE(id_commande),
    FOREIGN KEY (id_cadeaux) REFERENCES CADEAUX(id_cadeaux)
);

ALTER TABLE CADEAUX
ADD COLUMN photo_url VARCHAR(255) NOT NULL;


-- Création de la table COMMISSION
CREATE TABLE COMMISSION (
    id_commission INT PRIMARY KEY AUTO_INCREMENT,
    taux DECIMAL(5,2) NOT NULL,
    date_modification DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Insertion d'une valeur par défaut (10%)
INSERT INTO COMMISSION (taux) VALUES (10.00);

