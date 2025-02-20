CREATE DATABASE gestion_rdv;

CREATE TABLE `medecin` (
 `id_medecin` int NOT NULL AUTO_INCREMENT,
 `nom` varchar(255) NOT NULL,
 `prenom` varchar(100)  NOT NULL,
 `domaine` varchar(200) NOT NULL,
 PRIMARY KEY (`id_medecin`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci

CREATE TABLE `patients` (
 `id_patient` int NOT NULL AUTO_INCREMENT,
 `nom_prenom` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
 `telephone` varchar(100) NOT NULL,
 `email` varchar(100) NOT NULL,
 PRIMARY KEY (`id_patient`),
 UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci

CREATE TABLE `rendez_vous` (
 `id_rdv` int NOT NULL AUTO_INCREMENT,
 `id_patient` int NOT NULL,
 `date_heure` datetime NOT NULL,
 `id_medecin` int NOT NULL,
 PRIMARY KEY (`id_rdv`),
 KEY `rendez_vous_patients` (`id_patient`),
 KEY `rendez_vous_medecin` (`id_medecin`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci