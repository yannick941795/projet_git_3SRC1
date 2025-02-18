<?php
// Configuration de la base de données
$host = 'localhost';
$dbname = 'user_database';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

//je rajoute des choses pour le commit 
//je rajoute un deuxieme comment pour le commit



// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize user input
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $address = htmlspecialchars(trim($_POST['address']));
    $phone = htmlspecialchars(trim($_POST['phone']));

    // Simple validation
    $errors = [];

    if (strlen($username) < 3) {
        $errors[] = "Le nom d'utilisateur doit contenir au moins 3 caractères.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide.";
    }

    // Password validation: at least one uppercase, one lowercase, one digit, and 6 characters
    if (!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}/', $password)) {
        $errors[] = "Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre, et être long de 6 caractères ou plus.";
    }

    if (empty($address)) {
        $errors[] = "L'adresse ne peut pas être vide.";
    }

    if (!preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
        $errors[] = "Le numéro de téléphone doit être valide (10 à 15 chiffres).";
    }

    // Display errors or proceed
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    } else {
        // Here, you could save data to the database
        echo "<p style='color:green;'>Inscription réussie !</p>";
    }
}
?>
