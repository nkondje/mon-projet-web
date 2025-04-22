<?php
session_start();
require 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $sexe = $_POST["sexe"];
    $date_naissance = $_POST["date_naissance"];
    $pays_naissance = $_POST["pays_naissance"];
    $ville_naissance = $_POST["ville_naissance"];
    $ville_residence = $_POST["ville_residence"];
    $telephone = $_POST["telephone"];
    $email = $_POST["email"];
    $statut_matrimonial = $_POST["statut_matrimonial"];
    $partenaire_voyage = $_POST["partenaire_voyage"];
    $marie_auparavant = $_POST["marie_auparavant"];
    $date_mariage = $_POST["date_mariage"];
    $a_des_enfants = $_POST["a_des_enfants"];
    $nombre_enfants = $_POST["nombre_enfants"];
    $enfants_voyagent = $_POST["enfants_voyagent"];
    $nombre_total_personnes = $_POST["nombre_total_personnes"];
    $couleur_yeux = $_POST["couleur_yeux"];
    $taille_cm = $_POST["taille_cm"];
    $langue_maternelle = $_POST["langue_maternelle"];

    try {
        $stmt = $pdo->prepare("INSERT INTO informations_personnelles (
            user_id, nom, prenom, sexe, date_naissance, pays_naissance, ville_naissance, 
            ville_residence, telephone, email, statut_matrimonial, partenaire_voyage, 
            date_mariage, marie_auparavant, a_des_enfants, nombre_enfants, enfants_voyagent, 
            nombre_total_personnes, couleur_yeux, taille_cm, langue_maternelle
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $user_id, $nom, $prenom, $sexe, $date_naissance, $pays_naissance, $ville_naissance,
            $ville_residence, $telephone, $email, $statut_matrimonial, $partenaire_voyage, 
            $date_mariage, $marie_auparavant, $a_des_enfants, $nombre_enfants, $enfants_voyagent,
            $nombre_total_personnes, $couleur_yeux, $taille_cm, $langue_maternelle
        ]);

        header("Location: formulaire_documents.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de l'enregistrement : " . $e->getMessage();
    }
}
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
require 'config.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Informations personnelles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f7;
            margin: 0;
        }
        .container {
            background-color: #fff;
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #0055a5;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        .next-button {
            text-align: center;
            margin-top: 30px;
        }
        .next-button a button {
            padding: 10px 20px;
            background-color: #0055a5;
            color: white;
            border: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Page 1 : Informations personnelles</h2>
    <form method="post" action="formulaire_informations.php">
        <label>Nom *</label>
        <input type="text" name="nom" required>
        <label>Prénom *</label>
        <input type="text" name="prenom" required>
        <label>Sexe *</label>
        <select name="sexe" required>
            <option value="">--Choisissez--</option>
            <option value="Masculin">Masculin</option>
            <option value="Féminin">Féminin</option>
        </select>
        <label>Date de naissance *</label>
        <input type="date" name="date_naissance" required>
        <label>Pays de naissance *</label>
        <select name="pays_naissance" required>
            <option value="">--Choisissez votre pays--</option>
            <option value="Canada">Canada</option>
            <option value="Cameroun">Cameroun</option>
            <option value="France">France</option>
            <option value="Sénégal">Sénégal</option>
            <option value="Côte d'Ivoire">Côte d'Ivoire</option>
        </select>
        <label>Ville de naissance *</label>
        <input type="text" name="ville_naissance" required>
        <label>Ville de résidence actuelle *</label>
        <input type="text" name="ville_residence" required>
        <label>Téléphone *</label>
        <input type="tel" name="telephone" required>
        <label>E-mail *</label>
        <input type="email" name="email" required>
        <label>Quel est votre Statut matrimonial ? *</label>
        <select name="statut_matrimonial" required>
            <option value="">--Sélectionnez--</option>
            <option value="Marié(e)">Marié(e)</option>
            <option value="Célibataire">Célibataire</option>
            <option value="Veuf(ve)">Veuf(ve)</option>
            <option value="Divorcé(e)">Divorcé(e)</option>
            <option value="Conjoint de fait">Conjoint de fait</option>
            <option value="Autre">Autre</option>
        </select>
        <label>Est-ce que votre partenaire voyage avec vous ? *</label>
        <select name="partenaire_voyage" required>
            <option value="">--Sélectionnez--</option>
            <option value="Oui">Oui</option>
            <option value="Non">Non</option>
            <option value="Je ne suis pas marie(é)">Je ne suis pas marié</option>

            </select>
        <label>Quelle est la Date de votre mariage si vous etes marie(é) ?*</label>
        <input type="date" name="date_mariage">

        </select>
        <label>Avez-vous déjà été marié(e) auparavant avant de divrorcer ? *</label>
        <select name="marie_auparavant" required>
            <option value="">--Sélectionnez--</option>
            <option value="Oui">Oui</option>
            <option value="Non">Non</option>

    </select>               
        <label>Avez-vous des enfants ? *</label>
        <select name="a_des_enfants" required>
            <option value="">--Sélectionnez--</option>
            <option value="Oui">Oui</option>
            <option value="Non">Non</option>
        </select>
        <label>Combien d'enfants avez-vous ? *</label>
        <input type="number" name="nombre_enfants" min="0" required>
        <label>Voyagez-vous avec vos enfants ? *</label>
        <select name="enfants_voyagent" required>
            <option value="">--Sélectionnez--</option>
            <option value="Oui">Oui</option>
            <option value="Non">Non</option>
        </select>
        <label>Quel est nombre total de personnes dans le dossier ?*</label>
        <input type="number" name="nombre_total_personnes" min="1" required>
        <label>Quelle est la Couleur de vos yeux ? *</label>
        <input type="text" name="couleur_yeux" required>
        <label>Quelle est votre taille (en cm) ?*</label>
        <input type="number" name="taille_cm" required>
        <label>Quelle est votre Langue maternelle ?*</label>
        <input type="text" name="langue_maternelle" required>

        <div class="next-button">
            <button type="submit">Suivant ➡</button>
        </div>
    </form>
</div>
</body>
</html>
