<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$success_message = "";

// Mise à jour des données si formulaire soumis
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["section"])) {
    $section = $_POST["section"];
    unset($_POST["section"]);

    $set_clause = "";
    $values = [];

    foreach ($_POST as $champ => $valeur) {
        $set_clause .= "$champ = ?, ";
        $values[] = $valeur;
    }

    $set_clause = rtrim($set_clause, ", ");
    $values[] = $user_id;

    $stmt = $pdo->prepare("UPDATE $section SET $set_clause WHERE user_id = ?");
    $stmt->execute($values);
    $success_message = "✅ Modifications enregistrées.";
}

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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résumé du Dossier</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f1f1f1; }
        .container { background: white; padding: 30px; border-radius: 8px; max-width: 1000px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { color: #0055a5; text-align: center; }
        h3 { color: #444; margin-top: 40px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #e9e9e9; text-align: left; width: 30%; }
        input[type="text"] { width: 100%; padding: 6px; }
        .edit-section { text-align: right; margin-top: 10px; }
        .edit-btn {
            background-color: #0055a5; color: white;
            padding: 8px 20px; border: none;
            border-radius: 5px; cursor: pointer;
        }
        .edit-btn:hover { background-color: #004080; }
        .message { margin-bottom: 20px; color: green; font-weight: bold; }
        .button-group { text-align: center; margin-top: 40px; }
        .button-group button {
            background-color: #28a745;
            color: white; padding: 12px 25px;
            border: none; border-radius: 5px;
            font-size: 16px; cursor: pointer;
        }
        .button-group button.download {
            background-color: #0069d9;
        }
        .button-group button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Résumé du Dossier d'Immigration</h2>

    <?php if ($success_message): ?>
        <p class="message"><?= $success_message ?></p>
    <?php endif; ?>

    <!-- Informations Personnelles -->
    <form method="post">
        <h3>Informations Personnelles</h3>
        <input type="hidden" name="section" value="informations_personnelles">
        <table>
        <?php if ($infos): ?>
            <?php foreach ($infos as $key => $value): ?>
                <?php if (!in_array($key, ['id', 'user_id'])): ?>
                    <tr>
                        <th><?= htmlspecialchars($key) ?></th>
                        <td><input type="text" name="<?= $key ?>" value="<?= htmlspecialchars($value) ?>" required></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="2">Aucune information personnelle trouvée.</td></tr>
        <?php endif; ?>
        </table>
        <div class="edit-section">
            <button type="submit" class="edit-btn">Enregistrer</button>
        </div>
    </form>

    <!-- Documents d'identité -->
    <form method="post">
        <h3>Documents d'identité</h3>
        <input type="hidden" name="section" value="documents_identite">
        <table>
        <?php if ($docs): ?>
            <?php foreach ($docs as $key => $value): ?>
                <?php if (!in_array($key, ['id', 'user_id'])): ?>
                    <tr>
                        <th><?= htmlspecialchars($key) ?></th>
                        <td><input type="text" name="<?= $key ?>" value="<?= htmlspecialchars($value) ?>" required></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="2">Aucun document d'identité trouvé.</td></tr>
        <?php endif; ?>
        </table>
        <div class="edit-section">
            <button type="submit" class="edit-btn">Enregistrer</button>
        </div>
    </form>

    <!-- Enfants -->
    <?php if ($enfants): ?>
        <?php foreach ($enfants as $enfant): ?>
        <form method="post">
            <h3>Informations Enfant</h3>
            <input type="hidden" name="section" value="enfants">
            <table>
            <?php foreach ($enfant as $col => $val): ?>
                <?php if (!in_array($col, ['id', 'user_id'])): ?>
                    <tr>
                        <th><?= htmlspecialchars($col) ?></th>
                        <td><input type="text" name="<?= $col ?>" value="<?= htmlspecialchars($val) ?>" required></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            </table>
            <div class="edit-section">
                <button type="submit" class="edit-btn">Enregistrer</button>
            </div>
        </form>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Boutons -->
    <div class="button-group">
        <form method="post" action="generer_resume_pdf.php" style="display:inline;">
            <button type="submit" class="download">📄 Télécharger le résumé en PDF</button>
        </form>

        <form method="post" action="valider_dossier.php" style="display:inline; margin-left: 20px;">
            <button type="submit">✔ Valider et soumettre le dossier</button>
        </form>
    </div>
</div>
</body>
</html>
