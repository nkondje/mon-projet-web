<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

try {
    $conn = new PDO('mysql:host=localhost;dbname=identification_db;charset=utf8', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT nom_fichier, taille, date_upload FROM fichiers WHERE user_id = :id ORDER BY date_upload DESC");
    $stmt->execute(['id' => $_SESSION["user_id"]]);
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eef2f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: #0055a5;
            text-align: center;
        }
        ul {
            list-style-type: none;
            padding-left: 0;
        }
        a.btn {
            display: inline-block;
            padding: 10px 16px;
            background-color: #0055a5;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 10px;
            transition: background-color 0.3s;
        }
        a.btn:hover {
            background-color: #003d7a;
        }
        .logout {
            text-align: center;
            margin-top: 40px;
        }
        .logout a {
            background-color: #c0392b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            font-size: 15px;
        }
        th, td {
            padding: 12px 16px;
            text-align: left;
        }
        th {
            background-color: #003d7a;
            color: white;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tbody tr:hover {
            background-color: #d1e7fd;
        }
        td a.download {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }
        td a.download:hover {
            text-decoration: underline;
        }
        .no-doc {
            text-align: center;
            color: #999;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION["user_name"]); ?> 👋</h1>

    <h2>Remplir votre dossier d'immigration</h2>
    <ul>
        <li><a class="btn" href="formulaire_informations.php">📝 Étape 1 : Informations personnelles</a></li>
        <li><a class="btn" href="formulaire_documents.php">📄 Étape 2 : Documents d'identité</a></li>
        <li><a class="btn" href="formulaire_enfants.php">👨‍👩‍👧 Étape 3 : Informations sur les enfants</a></li>
        <li><a class="btn" href="formulaire_resume.php">📋 Résumé du dossier</a></li>
    </ul>

    <h2>📂 Documents déjà soumis</h2>
    <?php if (count($documents) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom du fichier</th>
                    <th>Taille</th>
                    <th>Date de soumission</th>
                    <th>Télécharger</th>
                </tr>
            </thead>
            <tbody>
                <?php $index = 1; foreach ($documents as $doc): ?>
                    <tr>
                        <td><?= $index++ ?></td>
                        <td><?= htmlspecialchars($doc['nom_fichier']) ?></td>
                        <td><?= number_format($doc['taille'] / 1024, 2) ?> Ko</td>
                        <td><?= htmlspecialchars($doc['date_upload']) ?></td>
                        <td>
                            <a class="download" href="telecharger.php?file=<?= urlencode($doc['nom_fichier']) ?>">
                                📥 Télécharger
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-doc">Aucun document soumis pour le moment.</p>
    <?php endif; ?>

    <div class="logout">
        <a class="btn" href="immigration.php">Déconnexion</a>
    </div>
</div>

</body>
</html>
