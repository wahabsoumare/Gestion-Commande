<?php 
session_start();
include('../includes/redirectTo.php');
require_once('../includes/db.php');

// Vérifie si un idClient est passé en GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    try {
        $sqlDeleteClient = 'DELETE FROM client WHERE id = ?';
        $stmt = $pdo->prepare($sqlDeleteClient);
        $resultat = $stmt->execute([$id]);

        if ($resultat) {
            $_SESSION['message_add_client'] = 'CLIENT SUPPRIMÉ AVEC SUCCÈS';
            $_SESSION['message_add_client_time'] = time();
        } else {
            $_SESSION['message_add_client'] = 'ÉCHEC de la suppression du client.';
            $_SESSION['message_add_client_time'] = time();
        }
    } catch (PDOException $e) {
        // Log en cas d'erreur
        error_log("Erreur suppression client : " . $e->getMessage());
        $_SESSION['message_add_client'] = 'Une erreur est survenue.';
        $_SESSION['message_add_client_time'] = time();
    }

    header("Location: index.php");
    exit;
} else {
    // Aucun ID valide fourni, redirection
    $_SESSION['message_add_client'] = 'ID client invalide ou manquant.';
    $_SESSION['message_add_client_time'] = time();
    header("Location: index.php");
    exit;
}
?>