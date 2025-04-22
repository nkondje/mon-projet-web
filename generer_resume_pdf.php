<?php
require_once('tcpdf/tcpdf.php');
require 'config.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Récupération des données
$stmt1 = $pdo->prepare("SELECT * FROM informations_personnelles WHERE user_id = ?");
$stmt1->execute([$user_id]);
$infos = $stmt1->fetch(PDO::FETCH_ASSOC);

$stmt2 = $pdo->prepare("SELECT * FROM documents_identite WHERE user_id = ?");
$stmt2->execute([$user_id]);
$docs = $stmt2->fetch(PDO::FETCH_ASSOC);

$stmt3 = $pdo->prepare("SELECT * FROM enfants WHERE user_id = ?");
$stmt3->execute([$user_id]);
$enfants = $stmt3->fetchAll(PDO::FETCH_ASSOC);

// Création du PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

ob_clean(); // éviter toute sortie avant le PDF

$html = '<h1>Résumé du Dossier</h1>';

// Informations Personnelles
$html .= '<h2>Informations Personnelles</h2><table border="1" cellpadding="4">';
if ($infos && is_array($infos)) {
    foreach ($infos as $k => $v) {
        if ($k !== "id" && $k !== "user_id") {
            $html .= "<tr><th>$k</th><td>$v</td></tr>";
        }
    }
}
$html .= '</table>';

// Documents
$html .= '<h2>Documents d\'Identité</h2><table border="1" cellpadding="4">';
if ($docs && is_array($docs)) {
    foreach ($docs as $k => $v) {
        if ($k !== "id" && $k !== "user_id") {
            $html .= "<tr><th>$k</th><td>$v</td></tr>";
        }
    }
}
$html .= '</table>';

// Enfants
if ($enfants && is_array($enfants) && count($enfants) > 0) {
    $html .= '<h2>Enfants</h2><table border="1" cellpadding="4">';
    foreach ($enfants as $enfant) {
        $html .= "<tr>";
        foreach ($enfant as $k => $v) {
            if ($k !== "id" && $k !== "user_id") {
                $html .= "<td><strong>$k:</strong> $v</td>";
            }
        }
        $html .= "</tr>";
    }
    $html .= '</table>';
} else {
    $html .= "<p>Aucun enfant enregistré.</p>";
}

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('resume_dossier.pdf', 'I');
exit;
?>
