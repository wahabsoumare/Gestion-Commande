<?php
session_start();
include('../includes/redirectTo.php');
require_once('../includes/db.php');

// Récupérer la liste des clients
try {
    $stmt = $pdo->query("SELECT id, nom FROM client ORDER BY nom ASC");
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erreur récupération clients : " . $e->getMessage());
    $clients = [];
}

// Récupérer la liste des produits
try {
    $stmt = $pdo->query("SELECT id, nom, prix, stock FROM produit ORDER BY nom ASC");
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erreur récupération produits : " . $e->getMessage());
    $produits = [];
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idClient = $_POST['idClient'] ?? '';
    $produitsSelectionnes = $_POST['produits'] ?? [];
    $quantites = $_POST['quantites'] ?? [];

    if (empty($idClient)) {
        $error = "Veuillez sélectionner un client.";
    } elseif (empty($produitsSelectionnes)) {
        $error = "Veuillez sélectionner au moins un produit.";
    } else {
        try {
            $pdo->beginTransaction();

            // Insérer la commande
            $stmt = $pdo->prepare("INSERT INTO commande (idClient) VALUES (?)");
            $stmt->execute([$idClient]);
            $idCommande = $pdo->lastInsertId();

            // Préparer les requêtes
            $stmtProduit = $pdo->prepare("INSERT INTO commande_produit (idCommande, idProduit, quantite) VALUES (?, ?, ?)");
            $stmtUpdateStock = $pdo->prepare("UPDATE produit SET stock = stock - ? WHERE id = ? AND stock >= ?");

            foreach ($produitsSelectionnes as $idProduit) {
                $quantite = isset($quantites[$idProduit]) ? (int)$quantites[$idProduit] : 1;

                if ($quantite > 0) {
                    // Vérifier le stock actuel
                    $stmtStock = $pdo->prepare("SELECT stock FROM produit WHERE id = ?");
                    $stmtStock->execute([$idProduit]);
                    $stockActuel = $stmtStock->fetchColumn();

                    if ($stockActuel === false || $stockActuel < $quantite) {
                        throw new Exception("Stock insuffisant pour le produit ID $idProduit");
                    }

                    // Insérer le produit dans la commande
                    $stmtProduit->execute([$idCommande, $idProduit, $quantite]);

                    // Mettre à jour le stock
                    $stmtUpdateStock->execute([$quantite, $idProduit, $quantite]);
                }
            }

            $pdo->commit();

            $_SESSION['message_commande'] = "Commande créée avec succès et stock mis à jour.";
            $_SESSION['message_commande_time'] = time();

            header("Location: detailsCommande.php");
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            error_log("Erreur insertion commande : " . $e->getMessage());
            $error = "Erreur lors de la création de la commande : " . htmlspecialchars($e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle Commande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include('../includes/header.php') ?>
<div class="container mt-5">
    <div class="card shadow p-4 mx-auto" style="max-width: 700px;">
        <h4 class="text-center mb-4">Créer une nouvelle commande</h4>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <!-- Sélection du client -->
            <div class="mb-3">
                <label for="idClient" class="form-label">Client</label>
                <select name="idClient" id="idClient" class="form-control" required>
                    <option value="">-- Choisir un client --</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= htmlspecialchars($client['id']) ?>"><?= htmlspecialchars($client['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Sélection des produits -->
            <div class="mb-3">
                <label class="form-label">Produits</label>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Quantité</th>
                            <th>Sélectionner</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produits as $produit): ?>
                            <tr>
                                <td><?= htmlspecialchars($produit['nom']) ?></td>
                                <td><?= htmlspecialchars(number_format($produit['prix'], 2)) ?> FCFA</td>
                                <td><?= htmlspecialchars($produit['stock']) ?></td>
                                <td>
                                    <input type="number" name="quantites[<?= $produit['id'] ?>]" value="1" min="1" max="<?= $produit['stock'] ?>" class="form-control" style="width: 80px;">
                                </td>
                                <td>
                                    <input type="checkbox" name="produits[]" value="<?= $produit['id'] ?>">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary w-100">Enregistrer la commande</button>
            <div class="text-center mt-3">
                <a href="listeCommande.php" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
</body>
<?php include('../includes/footer.php') ?>
</html>