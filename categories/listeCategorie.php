<?php
session_start();
include('../includes/redirectTo.php');
require_once('../includes/db.php');

// Recherche
$search = $_GET['search'] ?? '';
$searchLike = '%' . $search . '%';

try {
    if (!empty($search)) {
        $stmt = $pdo->prepare("SELECT * FROM categorie WHERE nom LIKE :search ORDER BY nom ASC");
        $stmt->execute(['search' => $searchLike]);
    } else {
        $stmt = $pdo->query("SELECT * FROM categorie ORDER BY nom ASC");
    }
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $categories = [];
    error_log("Erreur liste catégorie : " . $e->getMessage());
}

// Message flash
$message = $_SESSION['message_categorie'] ?? null;
$message_time = $_SESSION['message_categorie_time'] ?? 0;
if ($message && time() - $message_time > 15) {
    unset($_SESSION['message_categorie'], $_SESSION['message_categorie_time']);
    $message = null;
}
?>

<!-- Bootstrap CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<?php include('../includes/header.php') ?>

<div class="container mt-5">
    <div class="card shadow p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Liste des catégories</h4>
            <a href="addCategorie.php" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Nouvelle catégorie
            </a>
        </div>

        <form method="GET" class="input-group mb-3">
            <input type="text" name="search" class="form-control" placeholder="Rechercher une catégorie..." value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-outline-secondary" type="submit">Rechercher</button>
        </form>

        <?php if ($message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-info">
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <?php if (isset($_SESSION['utilisateur_role']) && $_SESSION['utilisateur_role'] == 'admin'): ?>
                            <th class="text-end">Actions</th>
                        <?php endif ?>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($categories) > 0): ?>
                        <?php foreach ($categories as $categorie): ?>
                            <tr>
                                <td><?= $categorie['id'] ?></td>
                                <td><?= htmlspecialchars($categorie['nom']) ?></td>
                                
                                    
                                <?php if (isset($_SESSION['utilisateur_role']) && $_SESSION['utilisateur_role'] == 'admin'): ?>
                                    <td class="text-end">
                                        <!-- <a href="updateCategorie.php?id=<?= $categorie['id'] ?>" class="btn btn-sm btn-warning me-2">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> -->
                                        <a href="deleteCategorie.php?id=<?= $categorie['id'] ?>" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Supprimer cette catégorie ?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                </td>

                                <?php endif; ?>
                                    
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3" class="text-center">Aucune catégorie trouvée.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
</div>
<?php include('../includes/footer.php') ?>
