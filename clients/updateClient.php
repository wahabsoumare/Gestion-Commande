<?php
session_start();
require_once('../includes/db.php');

// Récupération des données du formulaire
$idClient = $_POST['idClient'] ?? '';
$nom = $_POST['nom'] ?? '';
// $prenom = $_POST['prenom'] ?? '';
$telephone = $_POST['telephone'] ?? '';
$email = $_POST['email'] ?? '';

// Vérification des champs obligatoires
if (empty($idClient) || empty($nom)) {
    echo "Erreur : Le nom, le prénom et l'identifiant client sont obligatoires.";
    exit;
}

// Requête de mise à jour
$sqlUpdateClient = "UPDATE client SET nom = ?, telephone = ?, email = ? WHERE id = ?";
$stmt = $pdo->prepare($sqlUpdateClient);

$resultat = $stmt->execute([$nom, $telephone, $email, $idClient]);

if ($resultat) {
    // Message de confirmation + redirection
    $_SESSION['message_add_client'] = 'CLIENT modifié AVEC SUCCÈS';
    $_SESSION['message_add_client_time'] = time();

    header("Location: index.php");
    exit;
} else {
    echo "Erreur lors de la modification du client.";
}
?>