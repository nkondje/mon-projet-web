<?php
// Paramètres de connexion à la base de données
$host = 'localhost';   // Serveur de la base de données (souvent localhost)
$dbname = 'identification_db'; // Nom de la base de données
$username = 'root';    // Nom d'utilisateur pour se connecter à MySQL
$password = '';        // Mot de passe pour MySQL (par défaut, c'est vide pour XAMPP)

try {
    // Créer une instance PDO pour la connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Définir le mode d'erreur PDO sur exception pour plus de sécurité
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si la connexion échoue, afficher l'erreur
    die("Erreur de connexion : " . $e->getMessage());
}
?>
