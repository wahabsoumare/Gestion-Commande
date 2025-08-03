<?php
session_start();
include('../includes/redirectTo.php');
require_once('../includes/db.php');

// Récupération des données du formulaire
$idCategorie = $_POST['idCategorie'] ?? '';
$nom = trim($_POST['nom'] ?? '');
var_dump($nom);
exit;
// Vérification des champs obligatoires
if (empty($idCategorie) || empty($nom)) {
    echo "Erreur : L'identifiant et le nom de la catégorie sont obligatoires.";
    exit;
}

try {
    $sqlUpdateCategorie = "UPDATE categorie SET nom = ? WHERE id = ?";
    $stmt = $pdo->prepare($sqlUpdateCategorie);
    $resultat = $stmt->execute([$nom, $idCategorie]);

    if ($resultat) {
        $_SESSION['message_update_categorie'] = 'Catégorie modifiée AVEC SUCCÈS';
        $_SESSION['message_update_categorie_time'] = time();
        header("Location: index.php");
        exit;
    } else {
        echo "Erreur lors de la modification de la catégorie.";
    }
} catch (PDOException $e) {
    error_log("Erreur update catégorie : " . $e->getMessage());
    echo "Une erreur est survenue lors de la modification.";
}
?>