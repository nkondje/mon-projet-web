<?php
$host = "localhost"; // Serveur MySQL (localhost pour XAMPP/WAMP)
$dbname = "identification_db"; // Nom de la base de données
$username = "root"; // Nom d’utilisateur (par défaut sur XAMPP)
$password = ""; // Mot de passe (vide sur XAMPP)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
