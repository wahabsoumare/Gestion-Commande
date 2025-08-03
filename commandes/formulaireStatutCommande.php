<?php
session_start();
include('../includes/redirectTo.php');
require_once('../includes/db.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de commande invalide.";
    exit;
}

$id = (int) $_GET['id'];

// Récupérer les infos de la commande
$stmt = $pdo->prepare("SELECT * FROM commande WHERE id = ?");
$stmt->execute([$id]);
$commande = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$commande) {
    echo "Commande introuvable.";
    exit;
}

$statuts = ['en attente', 'validée', 'expédiée', 'livrée', 'annulée'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le statut</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow p-4 mx-auto" style="max-width: 500px;">
        <h4 class="mb-4 text-center">Modifier le statut de la commande #<?= $commande['id'] ?></h4>
        <form action="updateCommandeStatus.php" method="POST">
            <input type="hidden" name="idCommande" value="<?= $commande['id'] ?>">

            <div class="mb-3">
                <label for="statut" class="form-label">Statut</label>
                <select name="statut" id="statut" class="form-select" required>
                    <?php foreach ($statuts as $s): ?>
                        <option value="<?= $s ?>" <?= ($s === $commande['statut']) ? 'selected' : '' ?>>
                            <?= ucfirst($s) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="detailsCommande.php" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>