# Gestion des rendez-vous médiacal avec Tailwind CSS

Un blog moderne et élégant développé en PHP avec une interface utilisateur Bootstrap 5, enrichi d'animations et d'effets visuels modernes.

## 🚀 Fonctionnalités

### Système d'Articles
- Interface utilisateur moderne et responsive
- Mise en page élégante avec tailwind css
- recherche des patients
- affichages des rendez-vous

### Recherche Avancée
- Recherche en temps réel (AJAX)
- Mise à jour dynamique des résultats
- Debouncing pour optimiser les performances
- Indicateur de chargement
- URLs partageables pour les résultats de recherche



### Design et UX
- Design responsive et mobile-first
- Animations fluides et transitions
- Thème de couleur personnalisé
- Police Poppins pour une meilleure lisibilité
- Icônes Font Awesome intégrées

## 🎨 Caractéristiques Techniques

### Frontend
- **Tailwind CSS** pour la mise en page
- **Font Awesome** pour les icônes
- **JavaScript** moderne avec Fetch API
- Animations CSS personnalisées
- Design responsive

### Backend
- **PHP 7.4+** avec PDO
- Architecture MVC simplifiée
- Gestion sécurisée des requêtes
- Protection contre les injections SQL
- Validation des données

### Performance
- Mise en cache des ressources
- Compression GZIP
- Optimisation des images
- Debouncing des requêtes AJAX
- Chargement différé (lazy loading)

## 📋 Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web (Apache recommandé)
- Extension PDO PHP activée
- mod_rewrite Apache activé

## 🛠️ Installation

1. Clonez le dépôt :
```bash
git clone https://github.com/fri25/Gestion_rdv.git
```

2. Importez la base de données :
```sql
-- Création de la base de données
CREATE DATABASE IF NOT EXISTS gestion_rdv;
USE gestion_rdv;

-- Structure des tables
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
```

3. Configurez votre fichier `includes/config.php` :
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'gestion_rdv');
define('DB_USER', 'votre_utilisateur');
define('DB_PASS', 'votre_mot_de_passe');
define('SITE_TITLE', 'Mon Blog Tech');
define('SITE_DESCRIPTION', 'Une application des gestion des patients et des rendez-vous médical');
```

4. Configurez votre serveur web :
   - Assurez-vous que mod_rewrite est activé
   - Le fichier .htaccess est configuré pour la gestion des erreurs et les redirections



## 🔒 Sécurité

- Protection contre les injections SQL (PDO)
- Échappement des données HTML (htmlspecialchars)
- Protection des fichiers sensibles (.htaccess)
- Validation des entrées utilisateur
- Headers de sécurité configurés

## 🎯 Fonctionnalités à Venir

- [ ] Système d'authentification
- [ ] Panel d'administration
- [ ] Mode sombre
- [ ] API REST
- [ ] Afficher les rendez-vous d’un patient spécifique
- [ ] Vérifier en temps réel la disponibilité d’un créneau horaire
- [ ] Cache avancé

## 🤝 Contribution

Les contributions sont les bienvenues ! Pour contribuer :

1. Forkez le projet
2. Créez une branche pour votre fonctionnalité
3. Committez vos changements
4. Poussez vers la branche
5. Ouvrez une Pull Request

## 📝 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 📧 Support

Pour toute question ou suggestion :
- Ouvrez une issue
- Contactez-nous via le formulaire sur la page À propos
- Email : elfridayemadje5@gmail.com
