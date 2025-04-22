<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    die("Accès non autorisé.");
}

if (!isset($_GET['file'])) {
    die("Aucun fichier spécifié.");
}

$nom_fichier = $_GET['file'];
$nom_fichier_securise = basename($nom_fichier);
$chemin = __DIR__ . "/fichiers/" . $nom_fichier_securise;

if (!file_exists($chemin)) {
    die("❌ Fichier introuvable.");
}

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . rawurldecode($nom_fichier_securise) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($chemin));
readfile($chemin);
exit;
