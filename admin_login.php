<?php
session_start();
require 'db.php'; // Connexion à la base de données

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Requête SQL pour récupérer l'utilisateur avec son rôle 'admin'
    $query = "SELECT * FROM users WHERE email = ? AND role = 'admin'";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Si un utilisateur est trouvé et que le mot de passe correspond
    if ($user && password_verify($password, $user['password_hash'])) {
        // Démarrer une session et stocker les informations de l'administrateur
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = 'admin'; // Définir le rôle de l'utilisateur comme administrateur

        // Rediriger vers le tableau de bord de l'administrateur
        header('Location: admin_dashboard.php');
        exit();
    } else {
        // Afficher un message d'erreur si les identifiants sont incorrects
        $error_message = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .login-container label {
            display: block;
            text-align: left;
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-container button {
            background-color: #007BFF;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .login-container button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-bottom: 20px;
        }

        .login-container p {
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Connexion Administrateur</h2>

        <?php if (isset($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form action="admin_login.php" method="post">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required placeholder="Entrez votre email">

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required placeholder="Entrez votre mot de passe">

            <button type="submit">Se connecter</button>
        </form>
    </div>

</body>
</html>
