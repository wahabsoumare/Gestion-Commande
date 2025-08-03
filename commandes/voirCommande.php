<?php
session_start();
include('../includes/redirectTo.php');
require_once('../includes/db.php');

// Vérifier que l'ID est fourni
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID commande invalide.";
    exit;
}

$idCommande = (int)$_GET['id'];

// Récupérer les informations de la commande
try {
    $stmt = $pdo->prepare("
        SELECT c.id, c.dateCommande, cl.nom AS nomClient, cl.email, cl.telephone
        FROM commande c
        JOIN client cl ON c.idClient = cl.id
        WHERE c.id = ?
    ");
    $stmt->execute([$idCommande]);
    $commande = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$commande) {
        echo "Commande introuvable.";
        exit;
    }

    // Récupérer les produits associés à la commande
    $stmtProduits = $pdo->prepare("
        SELECT p.nom, p.prix, cp.quantite, (p.prix * cp.quantite) AS total
        FROM commande_produit cp
        JOIN produit p ON cp.idProduit = p.id
        WHERE cp.idCommande = ?
    ");
    $stmtProduits->execute([$idCommande]);
    $produits = $stmtProduits->fetchAll(PDO::FETCH_ASSOC);

    // Calcul du total global
    $totalGlobal = 0;
    foreach ($produits as $p) {
        $totalGlobal += $p['total'];
    }

} catch (PDOException $e) {
    error_log("Erreur voir commande : " . $e->getMessage());
    echo "Erreur lors de la récupération des détails de la commande.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de la commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow p-4">
        <h4 class="mb-4 text-center">Détails de la commande #<?= htmlspecialchars($commande['id']) ?></h4>

        <div class="mb-3">
            <strong>Client :</strong> <?= htmlspecialchars($commande['nomClient']) ?><br>
            <strong>Email :</strong> <?= htmlspecialchars($commande['email']) ?><br>
            <strong>Téléphone :</strong> <?= htmlspecialchars($commande['telephone']) ?><br>
            <strong>Date :</strong> <?= htmlspecialchars($commande['dateCommande']) ?>
        </div>

        <h5>Produits commandés :</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-info">
                    <tr>
                        <th>Produit</th>
                        <th>Prix (FCFA)</th>
                        <th>Quantité</th>
                        <th>Total (FCFA)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($produits) > 0): ?>
                        <?php foreach ($produits as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['nom']) ?></td>
                                <td><?= number_format($p['prix'], 2) ?></td>
                                <td><?= htmlspecialchars($p['quantite']) ?></td>
                                <td><?= number_format($p['total'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="table-secondary">
                            <td colspan="3" class="text-end"><strong>Total Global :</strong></td>
                            <td><strong><?= number_format($totalGlobal, 2) ?> FCFA</strong></td>
                        </tr>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center">Aucun produit dans cette commande.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <a href="detailsCommande.php" class="btn btn-secondary">Retour</a>
            <?php if (isset($_SESSION['utilisateur_role']) && $_SESSION['utilisateur_role'] == 'admin'): ?>
                <a href="deleteCommande.php?id=<?= urlencode($commande['id']) ?>" class="btn btn-danger"
                   onclick="return confirm('Voulez-vous vraiment supprimer cette commande ?')">
                    Supprimer
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>