<?php
session_start();
require_once '../includes/db.php'; // Connexion PDO

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $motdepasse = $_POST['motdepasse'];

    if (!empty($email) && !empty($motdepasse)) {
        // Requête pour récupérer l'utilisateur actif
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = :email AND statut = 1");
        $stmt->execute(['email' => $email]);
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur) {
            if (password_verify($motdepasse, $utilisateur['mot_de_passe'])) {
                // Connexion réussie
                $_SESSION['utilisateur_id'] = $utilisateur['id'];
                $_SESSION['utilisateur_nom'] = $utilisateur['nom'];
                $_SESSION['utilisateur_role'] = $utilisateur['role'];
                $_SESSION['connected'] = true;

                header('Location: ../clients/index.php');
                exit();
            } else {
                // Mauvais mot de passe
                $_SESSION['message_add_client'] = "Mot de passe incorrect.";
                $_SESSION['message_add_client_time'] = time();
                header('Location: login.php');
                exit();
            }
        } else {
            // Utilisateur non trouvé ou désactivé
            $_SESSION['message_add_client'] = "Utilisateur non trouvé ou inactif.";
            $_SESSION['message_add_client_time'] = time();
            header('Location: login.php');
            exit();
        }
    } else {
        // Champs vides
        $_SESSION['message_add_client'] = "Tous les champs sont requis.";
        $_SESSION['message_add_client_time'] = time();
        header('Location: login.php');
        exit();
    }
} else {
    // Requête directe non autorisée
    header('Location: login.php');
    exit();
}
