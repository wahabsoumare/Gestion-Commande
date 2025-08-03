<?php
session_start();
include('../includes/redirectTo.php');
require_once('../includes/db.php');

$categorie = null;

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM categorie WHERE id = ?");
    $stmt->execute([$id]);
    $categorie = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$categorie) {
        echo "Catégorie introuvable.";
        exit;
    }
} else {
    echo "ID catégorie manquant.";
    exit;
}
?>


<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <div class="card shadow p-4 mx-auto" style="max-width: 500px;">
        <h4 class="text-center mb-4">Modifier la catégorie</h4>
        <form action="updateCategorie.php" method="POST">
            <input type="hidden" name="idCategorie" value="<?= htmlspecialchars($categorie->id) ?>">

            <div class="mb-3">
                <label for="nom" class="form-label">Nom de la catégorie</label>
                <input type="text" id="nom" name="nom" class="form-control" 
                       value="<?= htmlspecialchars($categorie->nom) ?>" required>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="index.php" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
