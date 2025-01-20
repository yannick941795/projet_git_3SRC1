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

// Traitement des données du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $user = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Validation côté serveur
    if (strlen($user) < 3) {
        die("Le nom d'utilisateur doit contenir au moins 3 caractères.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Adresse email invalide.");
    }
    if (strlen($_POST['password']) < 6) {
        die("Le mot de passe doit contenir au moins 6 caractères.");
    }

    // Insertion dans la base de données
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $user);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $pass);
        $stmt->execute();
        echo "Inscription réussie !";
    } catch (PDOException $e) {
        die("Erreur lors de l'inscription : " . $e->getMessage());
    }
}
?>

