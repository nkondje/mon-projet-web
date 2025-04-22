<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'config.php'; // Connexion à la base de données

// Inclusion de PHPMailer
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    //$identification = trim($_POST["new-identification"]);
    $password = $_POST["new-password"];
    $confirm_password = $_POST["confirm-password"];

    // Vérifier si les mots de passe correspondent
    if ($password !== $confirm_password) {
        die("Les mots de passe ne correspondent pas.");
    }

    // Vérifier la complexité du mot de passe
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        die("Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial.");
    }

    // Vérifier si l'email ou le code d'identification existent déjà
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? ");
    $stmt->execute([$email]);

    if ($stmt->fetch()) {
        die("Cet email  est déjà utilisé.");
    }

    // Hacher le mot de passe
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Générer un token unique pour l'activation
    $token = bin2hex(random_bytes(50));

    // Insérer les données dans la base de données avec le token
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash, token, is_active) VALUES (?, ?, ?, ?, 0)");
    if ($stmt->execute([$name, $email, $password_hash, $token])) {
        
        // **Envoi de l'e-mail d'activation**
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Serveur SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'ankondje@gmail.com'; // Remplace par ton email Gmail
            $mail->Password = 'gftx zgnd zvtp vome'; // Remplace par ton mot de passe SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('ankondje@gmail.com', 'GoToCanada');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Activation de votre compte';
            $mail->Body = "Bonjour $name,<br><br>
                Merci de vous être inscrit sur notre plateforme. <br>
                Pour activer votre compte, veuillez cliquer sur le lien suivant :<br>
                <a href='http://localhost/mon_projet/activate.php?token=$token'>Activer mon compte</a>.<br><br>
                Si vous n'avez pas fait cette demande, veuillez ignorer cet email.";

            $mail->send();
            echo "Inscription réussie ! Un e-mail d'activation a été envoyé à votre adresse.";
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi de l'e-mail d'activation : {$mail->ErrorInfo}";
        }
    } else {
        echo "Erreur lors de l'inscription.";
    }
}
?>

<!--?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'config.php'; // Connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $identification = trim($_POST["new-identification"]);
    $password = $_POST["new-password"];
    $confirm_password = $_POST["confirm-password"];

    // Vérifier si les mots de passe correspondent
    if ($password !== $confirm_password) {
        die("Les mots de passe ne correspondent pas.");
    }

    // Vérifier la complexité du mot de passe
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        die("Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial.");
    }

    // Vérifier si l'email ou le code d'identification existent déjà
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR identification_code = ?");
    $stmt->execute([$email, $identification]);

    if ($stmt->fetch()) {
        die("Cet email ou code d'identification est déjà utilisé.");
    }

    // Hacher le mot de passe pour la sécurité
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insérer les données dans la base de données
    $stmt = $pdo->prepare("INSERT INTO users (name, email, identification_code, password_hash) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$name, $email, $identification, $password_hash])) {
        echo "Inscription réussie. <a href='login.php'>Connectez-vous ici</a>";
    } else {
        echo "Erreur lors de l'inscription.";
    }
}
?>
