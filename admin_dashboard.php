<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: admin_login.php');
    exit();
}

$user_data = null;
$formulaires = [];
$documents = [];
$message_sent = false;
$email_recherche = $_POST['email_recherche'] ?? '';

// SUPPRESSION
if (isset($_POST['delete_file']) && isset($_POST['file_path'])) {
    $file_path = $_POST['file_path'];
    if (file_exists($file_path) && is_file($file_path)) {
        unlink($file_path);
    }
    $email_recherche = $_POST['email_utilisateur'] ?? '';
}

// CHARGEMENT
if (!empty($email_recherche)) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email_recherche]);
    $user_data = $stmt->fetch();

    if ($user_data) {
        $user_id = $user_data['id'];

        // FORMULAIRES
        $form_dir = 'formulaires/';
        if (is_dir($form_dir)) {
            $files = scandir($form_dir);
            foreach ($files as $file) {
                if ((strpos($file, "_{$user_id}_") !== false || strpos($file, "_{$user_id}.") !== false) && is_file($form_dir . $file)) {
                    $formulaires[] = $file;
                }
            }
        }

        // DOCUMENTS
        $stmt = $pdo->prepare("SELECT * FROM fichiers WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $results = $stmt->fetchAll();
        foreach ($results as $row) {
            if (file_exists("fichiers/" . $row['nom_fichier'])) {
                $documents[] = $row['nom_fichier'];
            }
        }
    } else {
        $error_message = "Aucun utilisateur trouvé avec cet email.";
    }
}

// ENVOI DE MESSAGE
if (isset($_POST['send_message']) && !empty($_POST['message'])) {
    $message = $_POST['message'];
    $user_id = $_POST['user_id'];

    $stmt = $pdo->prepare("INSERT INTO messages (user_id, admin_id, message, message_type, subject) VALUES (?, ?, ?, 'notification', 'Message de l\'administrateur')");
    $stmt->execute([$user_id, $_SESSION['user_id'], $message]);

    $message_sent = true;
}

// MESSAGES REÇUS PAR L'ADMIN DE CHAQUE USAGER
$messages_recus = [];
if (!empty($user_data)) {
    $stmt = $pdo->prepare("
        SELECT * FROM messages 
        WHERE to_user_id = 12 AND from_user_id = ? 
        ORDER BY date_message DESC
    ");
    $stmt->execute([$user_data['id']]);
    $messages_recus = $stmt->fetchAll();
}



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Administrateur</title>
    <style>
        body { font-family: Arial; background: #f4f4f9; padding: 20px; }
        .dashboard-container { max-width: 900px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1, h3 { color: #333; text-align: center; }
        .section-box { margin-top: 30px; padding: 20px; border: 1px solid #ccc; border-radius: 8px; background-color: #fafafa; }
        .input-field, .button, textarea { width: 100%; padding: 10px; margin-top: 10px; box-sizing: border-box; }
        .button { background-color: #007BFF; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; }
        .button:hover { background-color: #0056b3; }
        .file-row { display: flex; justify-content: space-between; align-items: center; margin: 8px 0; }
        .file-link { text-decoration: none; color: #007BFF; }
        .delete-btn { background: none; border: none; cursor: pointer; }
        .message-box { background: #fefefe; border-left: 4px solid #007BFF; padding: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>
<div class="dashboard-container">
    <h1>Tableau de bord Administrateur</h1>
    <form method="POST">
        <input type="email" name="email_recherche" class="input-field" value="<?= htmlspecialchars($email_recherche) ?>" placeholder="Entrez l'email du candidat" required>
        <button type="submit" class="button">Rechercher le dossier</button>
    </form>

    <?php if ($user_data): ?>
        <div class="section-box">
            <h3>👤 Informations utilisateur</h3>
            <p><strong>Nom:</strong> <?= htmlspecialchars($user_data['name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($user_data['email']) ?></p>
        </div>

        <div class="section-box">
            <h3>📄 Dossiers soumis</h3>
            <?php if (!empty($formulaires)): ?>
                <?php foreach ($formulaires as $form): ?>
                    <div class="file-row">
                        <a class="file-link" href="formulaires/<?= htmlspecialchars($form) ?>" download><?= htmlspecialchars($form) ?></a>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="file_path" value="formulaires/<?= htmlspecialchars($form) ?>">
                            <input type="hidden" name="email_utilisateur" value="<?= htmlspecialchars($user_data['email']) ?>">
                            <button type="submit" name="delete_file" class="delete-btn" title="Supprimer">🗑️</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: gray;">Aucun formulaire trouvé.</p>
            <?php endif; ?>
        </div>

        <div class="section-box">
            <h3>📎 Documents soumis</h3>
            <?php if (!empty($documents)): ?>
                <?php foreach ($documents as $doc): ?>
                    <div class="file-row">
                        <a class="file-link" href="fichiers/<?= htmlspecialchars($doc) ?>" download><?= htmlspecialchars($doc) ?></a>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="file_path" value="fichiers/<?= htmlspecialchars($doc) ?>">
                            <input type="hidden" name="email_utilisateur" value="<?= htmlspecialchars($user_data['email']) ?>">
                            <button type="submit" name="delete_file" class="delete-btn" title="Supprimer">🗑️</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: gray;">Aucun document trouvé.</p>
            <?php endif; ?>
        </div>

        <div class="section-box">
            <h3>💬 Messages reçus</h3>
            <?php if (!empty($messages_recus)): ?>
                <?php foreach ($messages_recus as $msg): ?>
                    <div class="message-box">
                        <p><strong><?= htmlspecialchars($msg['subject'] ?? 'Sans sujet') ?> :</strong></p>
                        <p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
                        <p style="font-size: small; color: gray;">Envoyé le <?= $msg['date_message'] ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: gray;">Aucun message reçu de l'utilisateur.</p>
            <?php endif; ?>
        </div>

        <div class="section-box">
            <h3>💬 Envoyer un message</h3>
            <?php if ($message_sent): ?>
                <p style="color: green;">Message envoyé avec succès !</p>
            <?php endif; ?>
            <form method="POST">
                <textarea name="message" rows="4" placeholder="Votre message..." required></textarea>
                <input type="hidden" name="user_id" value="<?= $user_data['id'] ?>">
                <button type="submit" name="send_message" class="button">Envoyer le message</button>
            </form>
        </div>
    <?php elseif (!empty($error_message)): ?>
        <p style="color: red; text-align: center;"><?= $error_message ?></p>
    <?php endif; ?>
</div>
</body>
</html>
