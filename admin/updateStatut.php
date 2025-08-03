<?php
session_start();
require_once('../includes/db.php');

// Vérifier rôle admin
if (!isset($_SESSION['utilisateur_role']) || $_SESSION['utilisateur_role'] !== 'admin') {
    http_response_code(403);
    echo "<h1>403 - Accès interdit</h1>";
    exit;
}

$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

if ($id && is_numeric($id)) {
    try {
        if ($action === 'valider') {
            $stmt = $pdo->prepare("UPDATE utilisateur SET statut = 1 WHERE id = ?");
            $stmt->execute([$id]);
        } elseif ($action === 'rejet') {
            // Soit on supprime, soit on met statut=0
            $stmt = $pdo->prepare("DELETE FROM utilisateur WHERE id = ?");
            $stmt->execute([$id]);
        }
    } catch (PDOException $e) {
        error_log("Erreur mise à jour statut : " . $e->getMessage());
    }
}

header("Location: index.php");
exit;