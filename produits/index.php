<?php
session_start();
include('../includes/redirectTo.php');
require_once('../includes/db.php');
include('./listeProduit.php');

// Gestion message flash
$message = $_SESSION['message_produit'] ?? null;
$message_time = $_SESSION['message_produit_time'] ?? 0;
if ($message && time() - $message_time > 15) {
    unset($_SESSION['message_produit'], $_SESSION['message_produit_time']);
    $message = null;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body class="bg-light">
<div class="container-fluid p-0">

    <?php include("../includes/header.php"); ?>

    <div class="container mt-4">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col-md-6">
                <form method="GET" class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Rechercher un produit (nom, prix, catégorie)" value="<?= htmlspecialchars($search) ?>" />
                    <button class="btn btn-outline-success" type="submit">Rechercher</button>
                </form>
            </div>

            <?php if (isset($_SESSION['utilisateur_role']) && $_SESSION['utilisateur_role'] == 'admin'): ?>
                <div class="col-md-auto text-end">
                    <a href="formulaireProduit.php" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Nouveau produit
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive shadow-sm bg-white rounded">
            <table class="table table-hover align-middle">
                <thead class="table-info text-dark">
                    <tr>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Catégorie</th>
                        <?php if (isset($_SESSION['utilisateur_role']) && $_SESSION['utilisateur_role'] == 'admin'): ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                <?php if (count($listeProduits) > 0): ?>
                    <?php foreach ($listeProduits as $produit): ?>
                        <tr>
                            <td>
                                <?php if (!empty($produit['image']) && file_exists("../medias/" . $produit['image'])): ?>
                                    <img src="../medias/<?= htmlspecialchars($produit['image']) ?>" alt="Image produit" style="max-width:60px; max-height:40px;" class="rounded" />
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($produit['id']) ?></td>
                            <td><?= htmlspecialchars($produit['nom']) ?></td>
                            <td><?= number_format($produit['prix'], 2) ?> FCFA</td>
                            <td><?= htmlspecialchars($produit['stock']) ?></td>
                            <td><?= htmlspecialchars($produit['nomCategorie'] ?? 'Non classé') ?></td>

                            <?php if (isset($_SESSION['utilisateur_role']) && $_SESSION['utilisateur_role'] == 'admin'): ?>
                                <td>
                                    <a href="formulaireModificationProduit.php?id=<?= urlencode($produit['id']) ?>" class="btn btn-sm btn-warning me-1" title="Modifier">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="deleteProduit.php?id=<?= urlencode($produit['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce produit ?');" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="<?= (isset($_SESSION['utilisateur_role']) && $_SESSION['utilisateur_role'] == 'admin') ? 7 : 6 ?>" class="text-center">Aucun produit trouvé.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include("../includes/footer.php"); ?>

</div>
</body>
</html>
