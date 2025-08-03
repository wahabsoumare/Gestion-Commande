<?php
include('../includes/redirectTo.php');
include_once('../includes/db.php');

$listeCommandes = [];

$search = $_GET['search'] ?? '';
$searchLike = '%' . $search . '%';

try {
    if (!empty($search)) {
        $sql = "SELECT c.id, c.dateCommande, cl.nom AS nomClient
                FROM commande c
                INNER JOIN client cl ON c.idClient = cl.id
                WHERE c.id LIKE :search
                   OR cl.nom LIKE :search
                   OR c.dateCommande LIKE :search
                ORDER BY c.id DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['search' => $searchLike]);
    } else {
        $sql = "SELECT c.id, c.dateCommande, cl.nom AS nomClient
                FROM commande c
                INNER JOIN client cl ON c.idClient = cl.id
                ORDER BY c.id DESC";

        $stmt = $pdo->query($sql);
    }

    $listeCommandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erreur lors de la récupération des commandes : " . $e->getMessage());
    $listeCommandes = [];
}
?>