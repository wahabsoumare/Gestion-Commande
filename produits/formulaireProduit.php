<?php
// Récupération des catégories pour le select
require_once('../includes/db.php');

try {
    $stmt = $pdo->query("SELECT id, nom FROM categorie ORDER BY nom ASC");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $categories = [];
    error_log("Erreur récupération catégories : " . $e->getMessage());
}
?>

<!-- Bootstrap CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-5">
    <div class="card shadow p-4 mx-auto" style="max-width: 600px;">
        <h4 class="text-center mb-4">Formulaire d’ajout de produit</h4>

        <form action="addProduit.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom du produit</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>

            <div class="mb-3">
                <label for="prix" class="form-label">Prix (FCFA)</label>
                <input type="number" step="0.01" class="form-control" id="prix" name="prix" required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" required>
            </div>

            <div class="mb-3">
                <label for="idCategorie" class="form-label">Catégorie</label>
                <select class="form-select" id="idCategorie" name="idCategorie" required>
                    <option value="">-- Choisir une catégorie --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat['id']) ?>">
                            <?= htmlspecialchars($cat['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image du produit</label>
                <input type="file" class="form-control" name="image" id="image" accept="image/*">
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Ajouter le produit</button>
                <a href="index.php" class="btn btn-outline-secondary">← Retour à la liste</a>
            </div>
        </form>
    </div>
</div>