
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f1f1f1;
    padding: 20px;
}

form {
    background-color: #ffffff;
    border-radius: 8px;
    padding: 30px;
    max-width: 600px;
    margin: auto;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

h2 {
    text-align: center;
    color: #0055a5;
}

input, select, button {
    width: 100%;
    padding: 12px 15px;
    margin: 8px 0;
    box-sizing: border-box;
}

button {
    background-color: #0055a5;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
}

button:hover {
    background-color: #003d7a;
}
</style>
<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("INSERT INTO enfants (
        user_id, nom, prenom, date_naissance, sexe, ville_naissance, ville_habitation,
        est_aux_etudes, classe_etudes, voyage_avec_utilisateur, couleur_yeux, taille_cm, langue_maternelle
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $_SESSION["user_id"],
        $_POST["nom"],
        $_POST["prenom"],
        $_POST["date_naissance"],
        $_POST["sexe"],
        $_POST["ville_naissance"],
        $_POST["ville_habitation"],
        $_POST["est_aux_etudes"],
        $_POST["classe_etudes"],
        $_POST["voyage_avec_utilisateur"],
        $_POST["couleur_yeux"],
        $_POST["taille_cm"],
        $_POST["langue_maternelle"]
    ]);
    echo "Informations de l'enfant enregistrées.";
}
?>

<form method="post">
    <h2>Page 3 - Informations Enfants</h2>
    <input name="nom" required placeholder="Nom"><br>
    <input name="prenom" required placeholder="Prénom"><br>
    <input name="date_naissance" type="date" required><br>
    <select name="sexe" required><option>Masculin</option><option>Féminin</option></select><br>
    <input name="ville_naissance" required placeholder="Ville de naissance"><br>
    <input name="ville_habitation" required placeholder="Ville d'habitation"><br>
    <select name="est_aux_etudes" required><option>Oui</option><option>Non</option></select><br>
    <input name="classe_etudes" required placeholder="Classe"><br>
    <select name="voyage_avec_utilisateur" required><option>Oui</option><option>Non</option></select><br>
    <input name="couleur_yeux" required placeholder="Couleur des yeux"><br>
    <input name="taille_cm" type="number" required><br>
    <input name="langue_maternelle" required placeholder="Langue maternelle"><br>
    <button type="submit">Soumettre Page 3</button>
<div style='text-align:center; margin-top:20px;'>
<a href="formulaire_documents.php"><button type="button">⬅ Précédent</button></a>
<button type="submit">✔ Terminer</button>
</div>
</form>
