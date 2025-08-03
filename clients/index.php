<?php
session_start();
include('../includes/redirectTo.php');
require_once('../includes/db.php');
include('./listeClient.php');


// Gestion message flash
$message = $_SESSION['message_client'] ?? null;
$message_time = $_SESSION['message_client_time'] ?? 0;
if ($message && time() - $message_time > 15) {
    unset($_SESSION['message_client'], $_SESSION['message_client_time']);
    $message = null;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Clients</title>
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
                    <input type="text" name="search" class="form-control" placeholder="Rechercher un client" value="<?= htmlspecialchars($search) ?>" />
                    <button class="btn btn-outline-success" type="submit">Rechercher</button>
                </form>
            </div>

            <?php if (isset($_SESSION['utilisateur_role']) && $_SESSION['utilisateur_role'] == 'admin'): ?>
                <div class="col-md-auto text-end">
                    <a href="formulaireClient.php" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Nouveau client
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
                        <th>Photo</th>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <?php if (isset($_SESSION['utilisateur_role']) && $_SESSION['utilisateur_role'] == 'admin'): ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                <?php if (count($listeClient) > 0): ?>
                    <?php foreach ($listeClient as $client): ?>
                        <tr>
                            <td>
                                <?php if (!empty($client['photo']) && file_exists($client['photo'])): ?>
                                    <img src="<?= htmlspecialchars($client['photo']) ?>" alt="Photo client" style="max-width:60px; max-height:40px;" class="rounded" />
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($client['id']) ?></td>
                            <td><?= htmlspecialchars($client['nom']) ?></td>
                            <td><?= htmlspecialchars($client['email']) ?></td>
                            <td><?= htmlspecialchars($client['telephone']) ?></td>

                            <?php if (isset($_SESSION['utilisateur_role']) && $_SESSION['utilisateur_role'] == 'admin'): ?>
                                <td>
                                    <a href="formulaireModificationClient.php?id=<?= urlencode($client['id']) ?>" class="btn btn-sm btn-warning me-1" title="Modifier">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="deleteClient.php?id=<?= urlencode($client['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="<?= (isset($_SESSION['utilisateur_role']) && $_SESSION['utilisateur_role'] == 'admin') ? 6 : 5 ?>" class="text-center">Aucun client trouvé.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include("../includes/footer.php"); ?>

</div>
</body>
</html>