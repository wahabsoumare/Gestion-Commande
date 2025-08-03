<?php
session_start();
include('../includes/redirectTo.php');
require_once('../includes/db.php');

$nom = trim($_POST['nom'] ?? '');

if (!empty($nom)) {
    try {
        $sql = "INSERT INTO categorie (nom) VALUES (:nom)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':nom' => $nom]);

        $_SESSION['message_categorie'] = "Catégorie ajoutée avec succès.";
        $_SESSION['message_categorie_time'] = time();

        header("Location: listeCategorie.php");
        exit;
    } catch (PDOException $e) {
        echo "Erreur PDO : " . $e->getMessage();
    }
} else {
    // echo "Veuillez renseigner le nom de la catégorie.";
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-5">
    <div class="card shadow p-4 mx-auto" style="max-width: 500px;">
        <h4 class="text-center mb-4">Ajouter une catégorie</h4>

        <form action="addCategorie.php" method="POST">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom de la catégorie</label>
                <input type="text" class="form-control" id="nom" name="nom" placeholder="ex : Informatique" required>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Ajouter</button>
                <a href="listeCategorie.php" class="btn btn-outline-secondary">← Retour à la liste</a>
            </div>
        </form>
    </div>
</div>