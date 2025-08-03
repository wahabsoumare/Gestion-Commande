<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil - FLD Boutique</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<section class="container py-5">
  <div class="text-center mb-5">
    <h2 class="fw-bold">Bienvenue sur FLD boutique</h2>
    <p class="text-muted">Simplifiez la gestion de vos commandes, produits et clients.</p>
  </div>

  <div class="row text-center g-4">
    <!-- Produits -->
    <div class="col-md-4">
      <div class="p-4 border rounded-3 shadow-sm h-100">
        <div class="mb-3">
          <i class="bi bi-box-seam fs-1 text-primary"></i>
        </div>
        <h5 class="fw-bold">Gérez vos produits</h5>
        <p class="text-muted">Ajoutez, modifiez et suivez facilement votre catalogue de produits.</p>
      </div>
    </div>

    <!-- Commandes -->
    <div class="col-md-4">
      <div class="p-4 border rounded-3 shadow-sm h-100">
        <div class="mb-3">
          <i class="bi bi-cart-check fs-1 text-success"></i>
        </div>
        <h5 class="fw-bold">Suivez les commandes</h5>
        <p class="text-muted">Consultez et mettez à jour les commandes clients en temps réel.</p>
      </div>
    </div>

    <!-- Clients -->
    <div class="col-md-4">
      <div class="p-4 border rounded-3 shadow-sm h-100">
        <div class="mb-3">
          <i class="bi bi-people fs-1 text-warning"></i>
        </div>
        <h5 class="fw-bold">Gérez vos clients</h5>
        <p class="text-muted">Conservez les informations clients pour une meilleure relation commerciale.</p>
      </div>
    </div>
  </div>

  <div class="text-center mt-5">
    <a href="/gestionStockFLD/auth/login.php" class="btn btn-primary btn-lg">Commencer</a>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>