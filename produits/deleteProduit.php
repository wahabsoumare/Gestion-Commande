<?php 
session_start();
include('../includes/redirectTo.php');
require_once('../includes/db.php');

// Vérifie si un idProduit est passé en GET et est un entier
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        $sqlDeleteProduit = 'DELETE FROM produit WHERE id = ?';
        $stmt = $pdo->prepare($sqlDeleteProduit);
        $resultat = $stmt->execute([$id]);

        if ($resultat) {
            $_SESSION['message_update_produit'] = 'PRODUIT SUPPRIMÉ AVEC SUCCÈS';
            $_SESSION['message_update_produit_time'] = time();
        } else {
            $_SESSION['message_update_produit'] = 'ÉCHEC de la suppression du produit.';
            $_SESSION['message_update_produit_time'] = time();
        }
    } catch (PDOException $e) {
        error_log("Erreur suppression produit : " . $e->getMessage());
        $_SESSION['message_update_produit'] = 'Une erreur est survenue.';
        $_SESSION['message_update_produit_time'] = time();
    }

    header("Location: index.php");
    exit;
} else {
    $_SESSION['message_update_produit'] = 'ID produit invalide ou manquant.';
    $_SESSION['message_update_produit_time'] = time();
    header("Location: index.php");
    exit;
}
?>