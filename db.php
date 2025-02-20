<?php
// db.php : Fichier de connexion à la base de données
$host = 'localhost'; // Hôte MySQL (généralement localhost)
$dbname = 'gestion_rdv'; // Nom de la base de données
$username = 'root'; // Nom d'utilisateur MySQL (par défaut root pour XAMPP)
$password = ''; // Mot de passe MySQL (vide par défaut pour XAMPP)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Active les exceptions pour les erreurs PDO
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>