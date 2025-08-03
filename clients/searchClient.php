<?php
include('../includes/redirectTo.php');
include_once('../includes/db.php');

$listeProduits = [];

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = trim($_GET['search']);
    $searchLike = "%$search%";

    $sql = "SELECT p.*, c.nom AS categorie_nom
            FROM produit p
            LEFT JOIN categorie c ON p.idCategorie = c.id
            WHERE p.nom LIKE :search 
               OR c.nom LIKE :search";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['search' => $searchLike]);
    $listeProduits = $stmt->fetchAll(PDO::FETCH_OBJ);
} else {
    $listeProduits = [];
}
?>