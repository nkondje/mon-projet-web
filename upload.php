<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Chargement de fichiers - GoToCanada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f4f8;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            color: #004A99;
            margin-bottom: 30px;
        }

        form {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="file"] {
            margin-bottom: 20px;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #218838;
        }

        .dashboard-tab {
            display: inline-block;
            padding: 12px 24px;
            background-color: #004A99;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 6px;
            transition: background-color 0.3s;
            font-family: Arial, sans-serif;
        }

        .dashboard-tab:hover {
            background-color: #0066cc;
        }
    </style>
</head>
<body>

    <h2>📁 Bien vouloir charger les fichiers</h2>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="fichiers[]" multiple required><br>
        <button type="submit">Téléverser</button>
    </form>

    <a href="dashboard.php" class="dashboard-tab">🏠 Dashboard</a>

</body>
</html>



<?php
session_start();
require 'config.php'; // Connexion à la base de données via PDO

$upload_dir = "fichiers/";
$extensions_autorisees = ['pdf', 'jpg', 'jpeg', 'doc', 'docx'];
$taille_max = 4 * 1024 * 1024; // 4 Mo

// Simule une session utilisateur pour test (à supprimer en production)
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; // test temporaire
}

$user_id = $_SESSION['user_id'];

echo "<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Arial'>";
echo "<style>body{font-family:Arial;padding:30px;}p{margin:10px 0;}</style>";

if (!isset($_FILES['fichiers'])) {
    echo "<p style='color:red;'></p>";
    exit();
}

foreach ($_FILES['fichiers']['tmp_name'] as $index => $tmp_name) {
    $nom_original = basename($_FILES['fichiers']['name'][$index]);
    $extension = strtolower(pathinfo($nom_original, PATHINFO_EXTENSION));
    $taille = $_FILES['fichiers']['size'][$index];

    if (!in_array($extension, $extensions_autorisees)) {
        echo "<p style='color:red;'>❌ Format non autorisé : $nom_original</p>";
        continue;
    }

    if ($taille > $taille_max) {
        echo "<p style='color:red;'>❌ Taille trop grande (> 4 Mo) : $nom_original</p>";
        continue;
    }

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $chemin_final = $upload_dir . $nom_original;

    if (move_uploaded_file($tmp_name, $chemin_final)) {
        $stmt = $pdo->prepare("INSERT INTO fichiers (user_id, nom_fichier, taille) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $nom_original, $taille]);

        echo "<p style='color:green;'>✅ Fichier '$nom_original' téléversé avec succès.</p>";
    } else {
        echo "<p style='color:red;'>❌ Erreur lors du téléversement de '$nom_original'.</p>";
    }
}

echo "<p><a href='telechargements.php'>📂 Voir les fichiers disponibles</a></p>";
?>
