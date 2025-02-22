-- Création de la base de données
CREATE DATABASE gestion_rdv;

-- Sélection de la base de données
USE gestion_rdv;

-- Création de la table medecin
CREATE TABLE `medecin` (
  `id_medecin` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(255) NOT NULL,  -- Correction de "NéOT NULL" en "NOT NULL"
  `prenom` VARCHAR(100) NOT NULL,
  `domaine` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`id_medecin`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Création de la table patients
CREATE TABLE `patients` (
  `id_patient` INT NOT NULL AUTO_INCREMENT,
  `nom_prenom` VARCHAR(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id_patient`),
  UNIQUE KEY `email` (`email`)  -- Ajout de l'unicité sur l'email pour éviter les doublons
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Création de la table rendez_vous
CREATE TABLE `rendez_vous` (
  `id_rdv` INT NOT NULL AUTO_INCREMENT,
  `id_patient` INT NOT NULL,
  `date_heure` DATETIME NOT NULL,
  `id_medecin` INT NOT NULL,
  PRIMARY KEY (`id_rdv`),
  KEY `rendez_vous_patients` (`id_patient`),
  KEY `rendez_vous_medecin` (`id_medecin`),
  FOREIGN KEY (`id_patient`) REFERENCES `patients`(`id_patient`) ON DELETE CASCADE,  -- Ajout de la contrainte d'intégrité
  FOREIGN KEY (`id_medecin`) REFERENCES `medecin`(`id_medecin`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;  -- Correction du moteur de stockage de MyISAM vers InnoDB pour supporter les contraintes d'intégrité
