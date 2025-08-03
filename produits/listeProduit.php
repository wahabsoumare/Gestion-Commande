<?php
include('../includes/redirectTo.php');
include_once('../includes/db.php');

$listeProduits = [];

$search = $_GET['search'] ?? '';
$searchLike = '%' . $search . '%';

try {
    if (!empty($search)) {
        $sql = "SELECT 
                    p.id,
                    p.nom,
                    p.prix,
                    p.stock,
                    p.image,
                    p.idCategorie,
                    c.nom AS nomCategorie
                FROM produit p
                LEFT JOIN categorie c ON p.idCategorie = c.id
                WHERE p.nom LIKE :search 
                   OR p.prix LIKE :search
                   OR p.stock LIKE :search
                   OR c.nom LIKE :search
                ORDER BY p.id DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['search' => $searchLike]);
    } else {
        $sql = "SELECT 
                    p.id,
                    p.nom,
                    p.prix,
                    p.stock,
                    p.image,
                    p.idCategorie,
                    c.nom AS nomCategorie
                FROM produit p
                LEFT JOIN categorie c ON p.idCategorie = c.id
                ORDER BY p.id DESC";

        $stmt = $pdo->query($sql);
    }

    $listeProduits = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Erreur lors de la récupération des produits : " . $e->getMessage());
    $listeProduits = [];
}
?>