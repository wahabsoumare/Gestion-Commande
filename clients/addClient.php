<?php
session_start();

include('../includes/redirectTo.php');
require_once('../includes/db.php');

$nom = $_POST['nom'] ?? '';
// $prenom = $_POST['prenom'] ?? '';
$telephone = $_POST['telephone'] ?? '';
$email = $_POST['email'] ?? '';
// $adresse = $_POST['adresse'] ?? '';
$idClient = null;

if (!empty($nom)) {
    try {
        // 1. Insertion du client sans image
        $sql = "INSERT INTO client(nom, telephone, email) 
                VALUES (:nom, :telephone, :email)";
        $stmt = $pdo->prepare($sql);
        $resultat = $stmt->execute([
            ':nom'       => $nom,
            // ':prenom'    => $prenom,
            // ':adresse'   => $adresse,
            ':telephone' => $telephone,
            ':email' => $email
        ]);

        if ($resultat) {
            $idClient = $pdo->lastInsertId();
            $_SESSION['message_add_client'] = 'CLIENT AJOUTÉ AVEC SUCCÈS';
            $_SESSION['message_add_client_time'] = time();

            // 2. Upload de l'image si elle existe
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
                $dossier = 'medias/';
                if (!is_dir($dossier)) {
                    mkdir($dossier, 0755, true);
                }

                $nomTemp = $_FILES['photo']['tmp_name'];
                $nomFichier = uniqid() . '_' . basename($_FILES['photo']['name']);
                $cheminDestination = $dossier . $nomFichier;

                $typesAutorises = ['image/png', 'image/jpg', 'image/gif', 'image/jpeg'];

                if (in_array($_FILES['photo']['type'], $typesAutorises)) {
                    if (move_uploaded_file($nomTemp, $cheminDestination)) {
                        // Mise à jour du champ image
                        $sqlImage = "UPDATE client SET image = :image WHERE idClient = :idClient";
                        $stmtImage = $pdo->prepare($sqlImage);
                        $stmtImage->execute([
                            ':image'    => $nomFichier,
                            ':idClient' => $idClient
                        ]);
                    } else {
                        $_SESSION['message_add_client'] .= ' (Image non enregistrée)';
                    }
                }
            }

            // Redirection vers la page des clients
            header('Location: index.php');
            exit();
        } else {
            echo "Erreur lors de l'insertion du client.";
        }
    } catch (PDOException $e) {
        echo "Erreur PDO : " . $e->getMessage();
    }
}
?>
