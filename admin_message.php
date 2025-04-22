<?php
session_start();
require 'db.php'; // Connexion à la base de données

// Vérifier si l'utilisateur est un administrateur
if ($_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// Envoi du message
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les informations envoyées via le formulaire
    $user_id = $_POST['user_id'];
    $message = $_POST['message'];
    $message_type = $_POST['message_type'];  // Type de message (ex : notification)
    
    // Insérer le message dans la base de données
    $query = "INSERT INTO messages (user_id, message, message_type, vu) VALUES (?, ?, ?, 0)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id, $message, $message_type]);

    echo "Message envoyé avec succès!";
}

// Récupérer l'utilisateur et les fichiers soumis par l'utilisateur
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Récupérer les fichiers soumis par l'utilisateur
    $file_query = "SELECT * FROM fichiers WHERE user_id = ?";
    $file_stmt = $pdo->prepare($file_query);
    $file_stmt->execute([$user_id]);
    $files = $file_stmt->fetchAll();

    // Récupérer les messages de l'utilisateur
    $message_query = "SELECT * FROM messages WHERE user_id = ?";
    $message_stmt = $pdo->prepare($message_query);
    $message_stmt->execute([$user_id]);
    $messages = $message_stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoyer un message à l'utilisateur</title>
    <style>
        /* Styles CSS pour la page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
            text-align: center;
            color: #333;
        }

        .container p {
            font-size: 18px;
            text-align: center;
            color: #555;
        }

        .form-container {
            margin-top: 20px;
        }

        .form-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-container input, .form-container textarea, .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-container button {
            padding: 12px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        .files-container, .messages-container {
            margin-top: 30px;
        }

        .file-item, .message-item {
            margin-bottom: 10px;
        }

        .file-item a {
            color: #007BFF;
        }

        .file-item a:hover {
            text-decoration: underline;
        }

        .message-item {
            background-color: #f1f1f1;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Envoyer un message à l'utilisateur</h1>

        <form method="POST" class="form-container">
            <label for="user_id">ID Utilisateur:</label>
            <input type="text" name="user_id" value="<?php echo $user_id ?? ''; ?>" readonly required>

            <label for="message">Message:</label>
            <textarea name="message" required></textarea>

            <label for="message_type">Type de message:</label>
            <select name="message_type" required>
                <option value="notification">Notification</option>
                <option value="alert">Alerte</option>
                <option value="info">Information</option>
            </select>

            <button type="submit">Envoyer</button>
        </form>

        <!-- Affichage des fichiers soumis -->
        <div class="files-container">
            <h2>Fichiers soumis par l'utilisateur</h2>
            <?php if (isset($files) && count($files) > 0): ?>
                <?php foreach ($files as $file): ?>
                    <div class="file-item">
                        <p><strong>Nom du fichier:</strong> <a href="uploads/<?php echo $file['nom_fichier']; ?>" download><?php echo $file['nom_fichier']; ?></a></p>
                        <p><strong>Taille:</strong> <?php echo $file['taille']; ?> octets</p>
                        <p><strong>Date d'upload:</strong> <?php echo $file['date_upload']; ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun fichier soumis pour cet utilisateur.</p>
            <?php endif; ?>
        </div>

        <!-- Affichage des messages envoyés à l'utilisateur -->
        <div class="messages-container">
            <h2>Messages envoyés à l'utilisateur</h2>
            <?php if (isset($messages) && count($messages) > 0): ?>
                <?php foreach ($messages as $message): ?>
                    <div class="message-item">
                        <p><strong>Sujet:</strong> <?php echo htmlspecialchars($message['message_type']); ?></p>
                        <p><strong>Message:</strong> <?php echo htmlspecialchars($message['message']); ?></p>
                        <p><strong>Envoyé le:</strong> <?php echo $message['date_message']; ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun message envoyé à cet utilisateur.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
