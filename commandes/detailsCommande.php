<?php
session_start();
include('../includes/redirectTo.php');
require_once('../includes/db.php');
include('./listeCommande.php');

// Gestion message flash
$message = $_SESSION['message_commande'] ?? null;
$message_time = $_SESSION['message_commande_time'] ?? 0;
if ($message && time() - $message_time > 15) {
    unset($_SESSION['message_commande'], $_SESSION['message_commande_time']);
    $message = null;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Commandes</title>
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
                    <input type="text" name="search" class="form-control" placeholder="Rechercher une commande ou un client" value="<?= htmlspecialchars($search ?? '') ?>" />
                    <button class="btn btn-outline-success" type="submit">Rechercher</button>
                </form>
            </div>

                <div class="col-md-auto text-end">
                    <a href="addCommande.php" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Nouvelle commande
                    </a>
                </div>
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
                        <th>ID</th>
                        <th>Client</th>
                        <th>Date de commande</th>
                            <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (count($listeCommandes) > 0): ?>
                    <?php foreach ($listeCommandes as $commande): ?>
                        <tr>
                            <td><?= htmlspecialchars($commande['id']) ?></td>
                            <td><?= htmlspecialchars($commande['nomClient']) ?></td>
                            <td><?= htmlspecialchars($commande['dateCommande']) ?></td>

                                <td>
                                    <a href="voirCommande.php?id=<?= urlencode($commande['id']) ?>" class="btn btn-sm btn-info me-1" title="Voir détails">
                                        <i class="bi bi-eye"></i>
                                    </a>
                            <?php if (isset($_SESSION['utilisateur_role']) && $_SESSION['utilisateur_role'] == 'admin'): ?>

                                    <a href="deleteCommande.php?id=<?= urlencode($commande['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette commande ?');" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </a>
                            <?php endif; ?>

                                </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="<?= (isset($_SESSION['utilisateur_role']) && $_SESSION['utilisateur_role'] == 'admin') ? 4 : 3 ?>" class="text-center">Aucune commande trouvée.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include("../includes/footer.php"); ?>

</div>
</body>
</html>
