<?php
session_start();
include('../includes/redirectTo.php');
require_once('../includes/db.php');

$Client = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Utilisation de requête préparée pour plus de sécurité
    $stmt = $pdo->prepare("SELECT * FROM client WHERE id = ?");
    $stmt->execute([$id]);
    $Client = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$Client) {
        echo "Client introuvable.";
        exit;
    }
} else {
    echo "ID du client manquant.";
    exit;
}
?>

<!-- Bootstrap CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-5">
    <div class="card shadow p-4 mx-auto" style="max-width: 600px;">
        <h4 class="text-center mb-4">Formulaire de modification du client</h4>

        <form action="updateClient.php" method="POST">
            <input type="hidden" name="idClient" value="<?= htmlspecialchars($Client->id) ?>">

            <div class="mb-3">
                <label for="nom" class="form-label">Prénom Nom</label>
                <input type="text" class="form-control" id="nom" name="nom"
                       value="<?= htmlspecialchars($Client->nom) ?>" required>
            </div>

            <!-- <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom"
                       value="<?= htmlspecialchars($Client->prenom) ?>" required>
            </div> -->

            

            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="tel" class="form-control" id="telephone" name="telephone"
                       value="<?= htmlspecialchars($Client->telephone) ?>" required>
            </div>

            <div class="mb-3">
                <label for="adresse" class="form-label">Eamil</label>
                <input type="email" class="form-control" id="email" name="email"
                       value="<?= htmlspecialchars($Client->email) ?>" required>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="index.php" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</div>