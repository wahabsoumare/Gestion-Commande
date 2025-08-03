<?php
session_start();
include('../includes/redirectTo.php');
require_once('../includes/db.php');

// Vérifier si l'utilisateur est connecté et admin
if (!isset($_SESSION['utilisateur_role']) || $_SESSION['utilisateur_role'] !== 'admin') {
    http_response_code(403);
    echo "<h1>403 - Accès interdit</h1>";
    exit;
}

// Récupérer les demandes d'inscription en attente
try {
    $stmt = $pdo->query("SELECT id, nom, email, role, statut FROM utilisateur WHERE statut = 2");
    $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erreur récupération utilisateurs : " . $e->getMessage());
    $demandes = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demandes d'inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include('../includes/header.php') ?>
<div class="container mt-5">
    <div class="card shadow p-4">
        <h3 class="text-center mb-4">Demandes d'inscription</h3>

        <?php if (count($demandes) > 0): ?>
            <table class="table table-hover align-middle">
                <thead class="table-info text-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($demandes as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['nom']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td>
                            <a href="updateStatut.php?id=<?= urlencode($user['id']) ?>&action=valider" 
                               class="btn btn-success btn-sm"
                               onclick="return confirm('Valider cet utilisateur ?');">
                                Valider
                            </a>
                            <a href="updateStatut.php?id=<?= urlencode($user['id']) ?>&action=rejet" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Rejeter cet utilisateur ?');">
                                Rejeter
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info text-center">Aucune demande en attente.</div>
        <?php endif; ?>

        <div class="text-center mt-3">
            <a href="../index.php" class="btn btn-primary">Retour à l'accueil</a>
        </div>
    </div>
</div>
</body>
<?php include('../includes/footer.php') ?>
</html>