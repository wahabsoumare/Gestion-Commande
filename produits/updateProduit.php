<?php
session_start();
include('../includes/redirectTo.php');
require_once('../includes/db.php');

// Récupération des données du formulaire
$idProduit = $_POST['idProduit'] ?? '';
$nom = $_POST['nom'] ?? '';
$prix = $_POST['prix'] ?? '';
$stock = $_POST['stock'] ?? '';
$image = $_POST['image'] ?? ''; // On suppose que c'est un nom ou chemin de fichier (à adapter selon upload)
$idCategorie = $_POST['idCategorie'] ?? null; // Peut être null

// Vérification des champs obligatoires
if (empty($idProduit) || empty($nom) || $prix === '' || $stock === '') {
    echo "Erreur : L'identifiant produit, le nom, le prix et le stock sont obligatoires.";
    exit;
}

// Préparer la requête de mise à jour
$sqlUpdateProduit = "UPDATE produit SET nom = ?, prix = ?, stock = ?, image = ?, idCategorie = ? WHERE id = ?";
$stmt = $pdo->prepare($sqlUpdateProduit);

// Exécution de la requête
$resultat = $stmt->execute([$nom, $prix, $stock, $image, $idCategorie, $idProduit]);

if ($resultat) {
    // Message de confirmation + redirection
    $_SESSION['message_update_produit'] = 'Produit modifié AVEC SUCCÈS';
    $_SESSION['message_update_produit_time'] = time();

    header("Location: index.php");
    exit;
} else {
    echo "Erreur lors de la modification du produit.";
}
?>