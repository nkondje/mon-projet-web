<?php
require 'db.php'; // Connexion à la base de données
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Vérifier si l'ID du message est passé dans l'URL
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

// Récupérer l'ID du message à partir de l'URL
$message_id = $_GET['id'];
$user_id = $_SESSION['user_id']; // ID de l'utilisateur connecté

// Récupérer le message depuis la base de données
$query = "SELECT * FROM messages WHERE id = ? AND user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$message_id, $user_id]);
$message = $stmt->fetch();

if ($message) {
    // Afficher le contenu du message
    echo "<h1>Message</h1>";
    echo "<p><strong>Type :</strong> " . htmlspecialchars($message['message_type']) . "</p>";
    echo "<p><strong>Message :</strong></p>";
    echo "<p>" . nl2br(htmlspecialchars($message['message'])) . "</p>";
    echo "<p><strong>Date :</strong> " . $message['date_message'] . "</p>";

    // Marquer le message comme lu
    if ($message['vu'] == 0) {
        $update = "UPDATE messages SET vu = 1 WHERE id = ?";
        $stmt = $pdo->prepare($update);
        $stmt->execute([$message_id]);

        // Réduire le nombre de messages non lus de 1
        $update_count = "UPDATE users SET messages_non_lus = messages_non_lus - 1 WHERE id = ?";
        $stmt = $pdo->prepare($update_count);
        $stmt->execute([$user_id]);
    }

    echo "<p>Le message a été marqué comme lu.</p>";
} else {
    echo "<p>Message non trouvé ou accès non autorisé.</p>";
}
?>
