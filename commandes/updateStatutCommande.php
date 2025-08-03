<?php
session_start();
include('../includes/redirectTo.php');
require_once('../includes/db.php');

if (isset($_POST['idCommande'], $_POST['statut']) && is_numeric($_POST['idCommande'])) {
    $id = (int) $_POST['idCommande'];
    $statut = trim($_POST['statut']);

    try {
        $stmt = $pdo->prepare("UPDATE commande SET statut = ? WHERE id = ?");
        $result = $stmt->execute([$statut, $id]);

        if ($result) {
            $_SESSION['message_commande'] = "Statut mis à jour avec succès.";
        } else {
            $_SESSION['message_commande'] = "Échec de la mise à jour.";
        }
    } catch (PDOException $e) {
        error_log("Erreur modification statut commande : " . $e->getMessage());
        $_SESSION['message_commande'] = "Erreur lors de la mise à jour.";
    }
} else {
    $_SESSION['message_commande'] = "Données invalides.";
}

$_SESSION['message_commande_time'] = time();
header("Location: detailsCommande.php");
exit;
