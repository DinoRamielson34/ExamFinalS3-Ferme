-- Création de la base de données
CREATE DATABASE elevage;
USE elevage;

-- Création de la table users
CREATE TABLE elevage_Users (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Utilisation d'INT au lieu de SERIAL pour compatibilité
    email VARCHAR(255) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    capital DECIMAL(10, 2) DEFAULT NULL,
    role ENUM('client', 'admin') DEFAULT 'client'
);

-- Création de la table animaux
CREATE TABLE elevage_Animaux (
    id INT AUTO_INCREMENT PRIMARY KEY,
    espece VARCHAR(50) NOT NULL UNIQUE,
    poids_minimal_vente DECIMAL(5, 2) NOT NULL,
    prix_vente_kg DECIMAL(10, 2) NOT NULL,
    poids_maximal DECIMAL(5, 2) NOT NULL,
    nb_jour_sans_manger INT NOT NULL,
    pourcentage_perte_de_poids DECIMAL(5, 2) NOT NULL,
    poids_actuel DECIMAL(5, 2) NOT NULL DEFAULT 0,
    date_achat DATE NOT NULL,
    quota DECIMAL(10, 2) NOT NULL,
    photos TEXT
);

-- Création de la table alimentation
CREATE TABLE elevage_Alimentation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    pourcentage_gain DECIMAL(5, 2) NOT NULL,
    espece VARCHAR(50) NOT NULL,
    FOREIGN KEY (espece) REFERENCES elevage_Animaux(espece),
    photos TEXT
);

-- Création de la table achats pour les animaux
CREATE TABLE elevage_StockAnimal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    animal_id INT,
    quantite INT NOT NULL,
    date_achat DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES elevage_Users(id),
    FOREIGN KEY (animal_id) REFERENCES elevage_Animaux(id)
);

-- Création de la table achats pour les aliments
CREATE TABLE elevage_StockAliment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    aliment_id INT,
    quantite INT NOT NULL,
    date_achat DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES elevage_Users(id),
    FOREIGN KEY (aliment_id) REFERENCES elevage_Alimentation(id)
);

