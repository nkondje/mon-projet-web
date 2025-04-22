<?php
require 'config.php'; // Connexion à la base de données

if (isset($_GET["token"])) {
    $token = $_GET["token"];

    // Vérifier si le token existe en base de données
    $stmt = $pdo->prepare("SELECT id FROM users WHERE token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        // Activer le compte et supprimer le token
        $stmt = $pdo->prepare("UPDATE users SET is_active = 1, token = NULL WHERE id = ?");
        if ($stmt->execute([$user["id"]])) {
            echo "<div style='text-align:center; margin-top: 50px;'>
                    <h2>✅ Votre compte a été activé avec succès !</h2>
                    <p>Vous pouvez maintenant vous connecter.</p>


                    <a href='http://localhost/mon_projet/immigration.php' style='display:inline-block; padding: 10px 20px; font-size: 18px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px;'>Se connecter</a>
                  </div>";
        } else {
            echo "<h2>⚠️ Erreur lors de l'activation.</h2>";
        }
    } else {
        echo "<h2>❌ Token invalide ou compte déjà activé.</h2>";
    }
} else {
    echo "<h2>⚠️ Token manquant.</h2>";
}
?>