<?php
session_start();

include('../includes/redirectTo.php');
require_once('../includes/db.php');

$nom = $_POST['nom'] ?? '';
$prix = $_POST['prix'] ?? '';
$stock = $_POST['stock'] ?? '';
$idCategorie = $_POST['idCategorie'] ?? null;
$imageFichier = null;

if (!empty($nom) && is_numeric($prix) && is_numeric($stock)) {
    try {
        // 1. Insertion du produit (sans image pour le moment)
        $sql = "INSERT INTO produit (nom, prix, stock, idCategorie)
                VALUES (:nom, :prix, :stock, :idCategorie)";
        $stmt = $pdo->prepare($sql);
        $resultat = $stmt->execute([
            ':nom'         => $nom,
            ':prix'        => $prix,
            ':stock'       => $stock,
            ':idCategorie' => $idCategorie
        ]);

        if ($resultat) {
            $idProduit = $pdo->lastInsertId();
            $_SESSION['message_produit'] = 'PRODUIT AJOUTÉ AVEC SUCCÈS';
            $_SESSION['message_produit_time'] = time();

            // 2. Gestion de l'image si fournie
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $dossier = '../medias/';
                if (!is_dir($dossier)) {
                    mkdir($dossier, 0755, true);
                }

                $nomTemp = $_FILES['image']['tmp_name'];
                $nomFichier = uniqid() . '_' . basename($_FILES['image']['name']);
                $cheminDestination = $dossier . $nomFichier;

                $typesAutorises = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'];

                if (in_array($_FILES['image']['type'], $typesAutorises)) {
                    if (move_uploaded_file($nomTemp, $cheminDestination)) {
                        // Mise à jour du champ image
                        $sqlImage = "UPDATE produit SET image = :image WHERE id = :idProduit";
                        $stmtImage = $pdo->prepare($sqlImage);
                        $stmtImage->execute([
                            ':image'     => $nomFichier,
                            ':idProduit' => $idProduit
                        ]);
                    } else {
                        $_SESSION['message_produit'] .= ' (Image non enregistrée)';
                    }
                } else {
                    $_SESSION['message_produit'] .= ' (Type d\'image non autorisé)';
                }
            }

            header('Location: index.php');
            exit;
        } else {
            echo "Erreur lors de l'ajout du produit.";
        }
    } catch (PDOException $e) {
        echo "Erreur PDO : " . $e->getMessage();
    }
} else {
    echo "Veuillez remplir tous les champs obligatoires (nom, prix, stock).";
}
?>