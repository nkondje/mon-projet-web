
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
    $stmt = $pdo->prepare("INSERT INTO documents_identite (
        user_id, cni_numero, cni_pays, cni_ville, cni_date_delivrance, cni_date_expiration, cni_autorite,
        passeport_numero, passeport_pays, passeport_date_delivrance, passeport_date_expiration, passeport_autorite
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $_SESSION["user_id"],
        $_POST["cni_numero"],
        $_POST["cni_pays"],
        $_POST["cni_ville"],
        $_POST["cni_date_delivrance"],
        $_POST["cni_date_expiration"],
        $_POST["cni_autorite"],
        $_POST["passeport_numero"],
        $_POST["passeport_pays"],
        $_POST["passeport_date_delivrance"],
        $_POST["passeport_date_expiration"],
        $_POST["passeport_autorite"]
    ]);
    echo "Documents d'identité enregistrés.";
}
?>

<form method="post">
    <h2>Page 2 - Documents d'identité</h2>
    <input name="cni_numero" required placeholder="Numéro CNI"><br>
    <input name="cni_pays" required placeholder="Pays CNI"><br>
    <input name="cni_ville" required placeholder="Ville CNI"><br>
    <input name="cni_date_delivrance" type="date" required><br>
    <input name="cni_date_expiration" type="date" required><br>
    <input name="cni_autorite" required placeholder="Autorité CNI"><br>
    <input name="passeport_numero" required placeholder="Numéro Passeport"><br>
    <input name="passeport_pays" required placeholder="Pays Passeport"><br>
    <input name="passeport_date_delivrance" type="date" required><br>
    <input name="passeport_date_expiration" type="date" required><br>
    <input name="passeport_autorite" required placeholder="Autorité Passeport"><br>
    <button type="submit">Soumettre Page 2</button>
<div style='text-align:center; margin-top:20px;'>
<a href="formulaire_informations.php"><button type="button">⬅ Précédent</button></a>
<a href="formulaire_enfants.php"><button type="button">Suivant ➡</button></a>
</div>
</form>
