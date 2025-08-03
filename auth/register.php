<?php
session_start();
require_once('../includes/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    $mot_de_passe_confirm = $_POST['mot_de_passe_confirm'] ?? '';

    // Validation basique
    if (empty($nom) || empty($email) || empty($mot_de_passe)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide.";
    } elseif ($mot_de_passe !== $mot_de_passe_confirm) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        try {
            // Vérifier si l'email existe déjà
            $stmt = $pdo->prepare("SELECT id FROM utilisateur WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $error = "Cet email est déjà utilisé.";
            } else {
                // Hacher le mot de passe
                $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);

                // Insérer le nouvel utilisateur avec statut = 2 (en attente)
                $sql = "INSERT INTO utilisateur (nom, email, mot_de_passe, role, statut, image) 
                        VALUES (?, ?, ?, 'employe', 2, NULL)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nom, $email, $mot_de_passe_hash]);

                $_SESSION['message_register'] = "Inscription réussie ! En attente de validation par l’administrateur.";
                header("Location: login.php");
                exit;
            }
        } catch (PDOException $e) {
            error_log("Erreur inscription : " . $e->getMessage());
            $error = "Erreur lors de l'inscription.";
        }
    }
}
?>

<!-- Formulaire -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow p-4 mx-auto" style="max-width: 500px;">
        <h4 class="text-center mb-4">Créer un compte</h4>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom complet</label>
                <input type="text" name="nom" id="nom" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="mot_de_passe" class="form-label">Mot de passe</label>
                <input type="password" name="mot_de_passe" id="mot_de_passe" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="mot_de_passe_confirm" class="form-label">Confirmer le mot de passe</label>
                <input type="password" name="mot_de_passe_confirm" id="mot_de_passe_confirm" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
            <div class="text-center mt-3">
                <a href="login.php">Déjà un compte ? Se connecter</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>