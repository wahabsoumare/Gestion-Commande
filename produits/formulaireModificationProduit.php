<?php
session_start();
include('../includes/redirectTo.php');
require_once('../includes/db.php');

$produit = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Requête préparée sécurisée
    $stmt = $pdo->prepare("SELECT * FROM produit WHERE id = ?");
    $stmt->execute([$id]);
    $produit = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$produit) {
        echo "Produit introuvable.";
        exit;
    }
} else {
    echo "ID du produit manquant.";
    exit;
}

// Récupérer la liste des catégories pour le select
$stmtCat = $pdo->query("SELECT id, nom FROM categorie ORDER BY nom");
$categories = $stmtCat->fetchAll(PDO::FETCH_OBJ);
?>

<!-- Bootstrap CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-5">
    <div class="card shadow p-4 mx-auto" style="max-width: 600px;">
        <h4 class="text-center mb-4">Formulaire de modification du produit</h4>

        <form action="updateProduit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="idProduit" value="<?= htmlspecialchars($produit->id) ?>">

            <div class="mb-3">
                <label for="nom" class="form-label">Nom du produit</label>
                <input type="text" class="form-control" id="nom" name="nom"
                       value="<?= htmlspecialchars($produit->nom) ?>" required>
            </div>

            <div class="mb-3">
                <label for="prix" class="form-label">Prix (€)</label>
                <input type="number" step="0.01" min="0" class="form-control" id="prix" name="prix"
                       value="<?= htmlspecialchars($produit->prix) ?>" required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" min="0" class="form-control" id="stock" name="stock"
                       value="<?= htmlspecialchars($produit->stock) ?>" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image (URL ou fichier)</label>
                <!-- Afficher l'image actuelle si existe -->
                <?php if (!empty($produit->image)): ?>
                    <div class="mb-2">
                        <img src="<?= htmlspecialchars($produit->image) ?>" alt="Image produit" style="max-width: 150px;">
                    </div>
                <?php endif; ?>
                <!-- Pour simplifier, on met un champ texte pour l'URL/image -->
                <input type="text" class="form-control" id="image" name="image"
                       value="<?= htmlspecialchars($produit->image) ?>">
            </div>

            <div class="mb-3">
                <label for="idCategorie" class="form-label">Catégorie</label>
                <select class="form-select" id="idCategorie" name="idCategorie">
                    <option value="">-- Aucune catégorie --</option>
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?= $categorie->id ?>" <?= ($categorie->id == $produit->idCategorie) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($categorie->nom) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="index.php" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</div>
