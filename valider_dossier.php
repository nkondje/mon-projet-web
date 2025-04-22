<?php
session_start();
require 'config.php';
require('fpdf.php'); // Assurez-vous que fpdf.php est dans le dossier

// Vérification de la session
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Récupérer le nom de l'utilisateur
$stmt_user = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$stmt_user->execute([$user_id]);
$user_info = $stmt_user->fetch(PDO::FETCH_ASSOC);
$nom_utilisateur = $user_info ? $user_info['name'] : 'utilisateur';

// Récupération des données du dossier
$stmt1 = $pdo->prepare("SELECT * FROM informations_personnelles WHERE user_id = ?");
$stmt1->execute([$user_id]);
$infos = $stmt1->fetch(PDO::FETCH_ASSOC);

$stmt2 = $pdo->prepare("SELECT * FROM documents_identite WHERE user_id = ?");
$stmt2->execute([$user_id]);
$docs = $stmt2->fetch(PDO::FETCH_ASSOC);

$stmt3 = $pdo->prepare("SELECT * FROM enfants WHERE user_id = ?");
$stmt3->execute([$user_id]);
$enfants = $stmt3->fetchAll(PDO::FETCH_ASSOC);

// Génération du PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, utf8_decode("Résumé du Dossier d'Immigration"), 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);

// Infos personnelles
$pdf->Ln(5);
$pdf->Cell(0, 10, utf8_decode("Informations Personnelles:"), 0, 1);
if ($infos) {
    foreach ($infos as $key => $value) {
        if (!in_array($key, ['id', 'user_id'])) {
            $pdf->Cell(0, 8, utf8_decode(ucfirst($key) . ": " . $value), 0, 1);
        }
    }
}

// Documents identité
$pdf->Ln(5);
$pdf->Cell(0, 10, utf8_decode("Documents d'identité:"), 0, 1);
if ($docs) {
    foreach ($docs as $key => $value) {
        if (!in_array($key, ['id', 'user_id'])) {
            $pdf->Cell(0, 8, utf8_decode(ucfirst($key) . ": " . $value), 0, 1);
        }
    }
}

// Enfants
$pdf->Ln(5);
$pdf->Cell(0, 10, utf8_decode("Informations Enfants:"), 0, 1);
if ($enfants) {
    foreach ($enfants as $enfant) {
        foreach ($enfant as $key => $value) {
            if (!in_array($key, ['id', 'user_id'])) {
                $pdf->Cell(0, 8, utf8_decode(ucfirst($key) . ": " . $value), 0, 1);
            }
        }
        $pdf->Ln(3);
    }
}

// Préparer le nom de fichier
$date = date("Ymd");
$clean_name = preg_replace('/[^a-zA-Z0-9]/', '_', strtolower($nom_utilisateur));
$filename = $clean_name . "_" . $user_id . "_" . $date . ".pdf";

// Sauvegarde du PDF
$folder = "formulaires/";
if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}
$filepath = $folder . $filename;
$pdf->Output('F', $filepath);

// Enregistrement dans la table fichiers
$stmt = $pdo->prepare("INSERT INTO fichiers (user_id, nom_fichier, taille) VALUES (?, ?, ?)");
$stmt->execute([$user_id, $filename, filesize($filepath)]);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dossier Soumis</title>
    <style>
        body { font-family: Arial; background: #f8f8f8; padding: 40px; }
        .message-box {
            max-width: 600px; margin: auto; background: white;
            padding: 30px; border-radius: 10px; text-align: center;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        a.button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 25px;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a.button:hover { background: #0056b3; }
    </style>
</head>
<body>
<div class="message-box">
    <h2 style='color:green;'>🎉 Votre dossier a bien été soumis pour traitement.</h2>
    <p><a class="button" href='dashboard.php'>Retour au tableau de bord</a></p>
    <p><a class="button" href='<?php echo $filepath; ?>' target="_blank">📄 Télécharger le PDF généré</a></p>
    <p><a class="button" href='upload.php'>Telecharger pieces jointes</a></p>
</div>
</body>
</html>
