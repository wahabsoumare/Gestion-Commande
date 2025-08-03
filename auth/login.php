
<?php
   session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Connexion - GestionCommandes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<small class="text-success">
<?php 
 if (!empty($_SESSION['message_add_client']) && !empty($_SESSION['message_add_client_time'])) {
    // Vérifie si moins de 60 secondes se sont écoulées
    if (time() - $_SESSION['message_add_client_time'] < 15) {
        echo $_SESSION['message_add_client'];
    } else {
        // Supprime le message après 60 secondes
        unset($_SESSION['message_add_client']);
        unset($_SESSION['message_add_client_time']);
    }
 }
?>
</small>
<body class="bg-light d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">

  <div class="card shadow p-4 mb-3" style="max-width: 400px; width: 100%;">
    <h4 class="text-center mb-4">Connexion</h4>

    <form action="traitement_login.php" method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="ex: utilisateur@mail.com" required>
      </div>

      <div class="mb-3">
        <label for="motdepasse" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="motdepasse" name="motdepasse" placeholder="Votre mot de passe" required>
      </div>

      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-primary">Se connecter</button>
      </div>
    </form>

    <div class="text-center">
      <p class="mb-0">Pas encore de compte ? <a href="register.php">S'inscrire</a></p>
    </div>
  </div>

  <!-- Footer inclus -->
  <div class="w-100 text-center mt-3">
    <?php include("../includes/footer.php"); ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>