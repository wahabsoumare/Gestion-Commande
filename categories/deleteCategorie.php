<?php
session_start();
include('../includes/redirectTo.php');
require_once('../includes/db.php');

// Vérifie si un idCategorie est passé en GET et est un entier
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        // Suppression de la catégorie
        $sqlDeleteCategorie = 'DELETE FROM categorie WHERE id = ?';
        $stmt = $pdo->prepare($sqlDeleteCategorie);
        $resultat = $stmt->execute([$id]);

        if ($resultat) {
            $_SESSION['message_update_categorie'] = 'CATÉGORIE SUPPRIMÉE AVEC SUCCÈS';
            $_SESSION['message_update_categorie_time'] = time();
        } else {
            $_SESSION['message_update_categorie'] = 'ÉCHEC de la suppression de la catégorie.';
            $_SESSION['message_update_categorie_time'] = time();
        }
    } catch (PDOException $e) {
        // En cas d'erreur (ex: clé étrangère liée), on log l'erreur et message utilisateur
        error_log("Erreur suppression catégorie : " . $e->getMessage());
        $_SESSION['message_update_categorie'] = 'Impossible de supprimer la catégorie (peut-être utilisée par des produits).';
        $_SESSION['message_update_categorie_time'] = time();
    }

    header("Location: listeCategorie.php");
    exit;
} else {
    $_SESSION['message_update_categorie'] = 'ID catégorie invalide ou manquant.';
    $_SESSION['message_update_categorie_time'] = time();
    header("Location: index.php");
    exit;
}
?>
