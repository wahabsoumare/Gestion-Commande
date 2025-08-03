<?php
include('../includes/redirectTo.php');
include_once('../includes/db.php');

$listeClient = [];

$search = $_GET['search'] ?? '';
$searchLike = '%' . $search . '%';

try {
    if (!empty($search)) {
    $sql = "SELECT * FROM client 
            WHERE nom LIKE :search 
            OR email LIKE :search 
            OR telephone LIKE :search
            ORDER BY id DESC";  //
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['search' => $searchLike]);
} else {
    $sql = "SELECT * FROM client ORDER BY id DESC";
    $stmt = $pdo->query($sql);
}


    $listeClient = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erreur lors de la récupération des clients : " . $e->getMessage());
    $listeClient = [];
}
?>