<?php
session_start();
require 'db.php'; // Connexion à la base de données

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Comptage des formulaires soumis (fichiers dans 'formulaires/' contenant _ID_ ou _ID.)
$formulaires_soumis = 0;
$form_dir = 'formulaires/';
if (is_dir($form_dir)) {
    $files = scandir($form_dir);
    foreach ($files as $file) {
        if ((strpos($file, "_{$user_id}_") !== false || strpos($file, "_{$user_id}.") !== false) && is_file($form_dir . $file)) {
            $formulaires_soumis++;
        }
    }
}

// Nombre de documents soumis
$query_documents = "SELECT COUNT(*) FROM fichiers WHERE user_id = ?";
$stmt = $pdo->prepare($query_documents);
$stmt->execute([$user_id]);
$documents_soumis = $stmt->fetchColumn();

// Nombre de messages reçus
$query_messages = "SELECT COUNT(*) FROM messages WHERE user_id = ?";
$stmt = $pdo->prepare($query_messages);
$stmt->execute([$user_id]);
$messages_reçus = $stmt->fetchColumn();

// Nombre de messages non lus
$query_unread_messages = "SELECT COUNT(*) FROM messages WHERE user_id = ? AND vu = 0";
$stmt = $pdo->prepare($query_unread_messages);
$stmt->execute([$user_id]);
$messages_non_lus = $stmt->fetchColumn();
// Envoi d'un message à l'administrateur (admin_id = 12)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message_to_admin'])) {
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['details'] ?? '');
    $admin_id = 12;

    if (!empty($subject) && !empty($message)) {
        $stmt = $pdo->prepare("INSERT INTO messages (user_id, from_user_id, to_user_id, admin_id, subject, message, message_type, vu) VALUES (?, ?, ?, ?, ?, ?, 'notification', 0)");
        $stmt->execute([$user_id, $user_id, $admin_id, $admin_id, $subject, $message]);
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - GoToCanada</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; display: flex; height: 100vh; }
        .sidebar { width: 250px; background-color: #0055a5; color: white; padding: 10px; height: 100vh; position: fixed; left: 0; top: 0; }
        .sidebar h2 { text-align: center; font-size: 22px; margin-bottom: 20px; }
        .sidebar ul { list-style-type: none; padding: 0; }
        .sidebar ul li { padding: 10px; border-bottom: 1px solid #ffffff33; }
        .sidebar ul li a { color: white; text-decoration: none; display: block; }
        .sidebar ul li a:hover { background-color: #003366; padding: 10px; }
        .sidebar .submenu { display: none; list-style-type: none; position: absolute; left: 100%; top: 0; background: #004a73; width: 200px; padding: 0; z-index: 1000; }
        .sidebar .submenu li { padding: 10px; border-bottom: 1px solid #ffffff33; }
        .sidebar .submenu li a { color: white; text-decoration: none; display: block; }
        .sidebar .submenu li a:hover { background-color: #003366; }
        .sidebar li.dropdown:hover .submenu { display: block; }
        .main-content { margin-left: 250px; padding: 20px; width: calc(100% - 250px); }
        .dashboard-header { color: white; padding: 15px; text-align: center; font-size: 20px; font-weight: bold; border-radius: 5px; margin-bottom: 20px; }
        .header-primary { background-color: #004A99; }
        .header-secondary { background-color: #008C45; }
        .welcome { font-size: 18px; }
        .logout-btn { float: right; background-color: #FF4444; color: white; padding: 5px 5px; text-decoration: none; border-radius: 0px; font-weight: bold; }
        .logout-btn:hover { background-color: #CC0000; }
        .stats-container { display: flex; justify-content: space-between; margin-top: 20px; }
        .stat-box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1); text-align: center; width: 30%; }
        .stat-box h3 { margin: 0; font-size: 18px; color: #333; }
        .stat-box p { font-size: 24px; font-weight: bold; color: #0055a5; }
        .unread-messages { margin-top: 40px; background: rgb(149, 162, 200); padding: 30px; border-radius: 8px; box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1); }
        .unread-messages a { display: block; color: #0055a5; text-decoration: none; padding: 10px 0; }
        .unread-messages a:hover { background-color: #e0e0e0; }
        .message-content { background: #fff; padding: 20px; margin-top: 20px; border-radius: 8px; box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1); }
        .message-title { font-weight: bold; font-size: 20px; }
        .message-body { margin-top: 10px; }
        .message-mark-read { color: #008C45; cursor: pointer; }
    </style>
</head>
<body>
<div class="sidebar">
    <h2>Menu</h2>
    <ul>
        <li><a href="immigration.php" target="_blank">Accueil</a></li>
        <li class="dropdown">
            <a href="#">Procédures ▾</a>
            <ul class="submenu">
                <li><a href="entreeexpress.php" target="_blank">Dossier Entrée Express</a></li>
                <li><a href="travailencours.html">Dossier Étudiant</a></li>
                <li><a href="travailencours.html">Dossier Regroupement Familial</a></li>
                <li><a href="travailencours.html">Travailleurs qualifiés Québec (ARRIMA)</a></li>
                <li><a href="travailencours.html">Travailleurs Temporaires</a></li>
                <li><a href="travailencours.html">Visiteur</a></li>
                <li><a href="travailencours.html">Demandeur d'Asile</a></li>
            </ul>
        </li>
        <li><a href="travailencours.html">Suivi de Dossier</a></li>
        <li><a href="travailencours.html">Mes Documents</a></li>
        <li><a href="travailencours.html">Paiements</a></li>
        <li><a href="travailencours.html">Messages</a></li>
        <li><a href="travailencours.html">Paramètres</a></li>
    </ul>
</div>
<div class="main-content">
    <div class="dashboard-header header-primary">
        <span class="welcome"><strong><h1>Tableau de Bord d'Immigration Canada</h1></strong></span>
    </div>
    <div class="dashboard-header header-secondary">
        <span class="welcome">Bienvenue, <strong><?php echo $_SESSION["user_name"]; ?></strong> 👋</span>
        <a href="immigration.php" class="logout-btn"> Déconnexion</a>
    </div>
    <div class="stats-container">
        <div class="stat-box">
            <h3>Dossiers soumis</h3>
            <p><?php echo $formulaires_soumis; ?></p>
        </div>
        <div class="stat-box">
            <h3>Documents soumis</h3>
            <p><?php echo $documents_soumis; ?></p>
        </div>
        <div class="stat-box">
            <h3>Messages reçus</h3>
            <p><?php echo $messages_reçus; ?></p>
        </div>
    </div>
    <div class="unread-messages">
        <h3>Messages non lus (<?php echo $messages_non_lus; ?>)</h3>
        <?php
        $query = "SELECT * FROM messages WHERE user_id = ? AND vu = 0 ORDER BY date_message DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$user_id]);
        $messages = $stmt->fetchAll();
        foreach ($messages as $message) {
            echo "<a href='dashboard.php?message_id=" . $message['id'] . "'>" . htmlspecialchars($message['message']) . "</a>";
        }
        ?>
    </div>
    <?php
    if (isset($_GET['message_id'])) {
        $message_id = $_GET['message_id'];
        $update_query = "UPDATE messages SET vu = 1 WHERE id = ?";
        $stmt = $pdo->prepare($update_query);
        $stmt->execute([$message_id]);

        $query_message = "SELECT * FROM messages WHERE id = ?";
        $stmt = $pdo->prepare($query_message);
        $stmt->execute([$message_id]);
        $message_to_read = $stmt->fetch();

        echo "<div class='message-content'>";
        echo "<p class='message-title'>" . htmlspecialchars($message_to_read['message']) . "</p>";
        echo "<div class='message-body'>" . nl2br(htmlspecialchars($message_to_read['details'])) . "</div>";
        echo "<p class='message-mark-read'>Ce message a été marqué comme lu</p>";
        echo "</div>";
    }
    


// Traitement de l'envoi de message à l'administrateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message_to_admin'])) {
    $subject = $_POST['subject'] ?? '';
    $details = $_POST['details'] ?? '';

    // Récupérer l'ID de l'administrateur
    $admin_stmt = $pdo->prepare("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
    $admin_stmt->execute();
    $admin = $admin_stmt->fetch(); 

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['send_message'])) {
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');
    
        if (!empty($message) && !empty($subject)) {
            // Récupère l'admin (si présent)
            $stmt = $pdo->prepare("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
            $stmt->execute();
            $admin = $stmt->fetch();
    
            if ($admin) {
                $admin_id = $admin['id'];
                $insert = $pdo->prepare("INSERT INTO messages (from_user_id, to_user_id, admin_id, subject, message, vu) VALUES (?, ?, ?, ?, ?, 0)");
                $insert->execute([$user_id, $admin_id, $admin_id, $subject, $message]);
            } else {
                echo "<p style='color:red;'>Aucun administrateur trouvé dans la base de données.</p>";
            }
        } else {
            echo "<p style='color:red;'>Veuillez remplir le sujet et le message.</p>";
        }
    }
    
}
?>

<!-- Ajouter ce bloc HTML dans <div class="main-content"> après le code existant -->
<div class="send-message" style="margin-top:40px; background:#fff; padding:30px; border-radius:8px; box-shadow:0 0 5px rgba(0,0,0,0.1);">
    <h3 style="margin-bottom:20px;">Contacter l'administrateur</h3>
    <form method="post">
        <input type="text" name="subject" placeholder="Objet du message" required style="width:100%; padding:10px; margin-bottom:10px;">
        <textarea name="details" rows="5" placeholder="Votre message..." required style="width:100%; padding:10px; margin-bottom:10px;"></textarea>
        <button type="submit" name="send_message_to_admin" style="background-color:#004A99; color:white; padding:10px 20px; border:none; border-radius:5px; cursor:pointer;">Envoyer</button>
    </form>
</div>

<!-- Fin du bloc ajouté -->
</div>



</body>
</html>
