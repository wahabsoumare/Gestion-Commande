<?php
// session_start();
include_once('../includes/redirectTo.php');

// Fonction pour appliquer la classe active selon la page
function isActive($path)
{
    return strpos($_SERVER['REQUEST_URI'], $path) !== false 
        ? 'nav-link active' 
        : 'text-white';
}
?>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<!-- En-tête -->
<header class="w-100 my-1">
  <nav class="navbar navbar-expand-lg navbar-light bg-info px-4">
    <div class="container-fluid">
      
      <!-- Logo / Nom de l'application -->
      <a class="navbar-brand fw-bold text-white" href="/index.php">GestionCommandes</a>

      <!-- Bouton hamburger pour mobile -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Basculer la navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Liens de navigation -->
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center gap-3">

          <li class="nav-item">
            <?php if (isset($_SESSION['utilisateur_role']) && $_SESSION['utilisateur_role'] == 'admin'): ?>
            <a class="nav-link <?= isActive('/gestionStockFLD/admin') ?>" href="/gestionStockFLD/admin/">LIste des demandes</a>
            <?php endif; ?>
          </li>
          
          <li class="nav-item">
            <a class="nav-link <?= isActive('/gestionStockFLD/clients') ?>" href="/gestionStockFLD/clients/">Clients</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= isActive('/gestionStockFLD/produits') ?>" href="/gestionStockFLD/produits/">Produits</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= isActive('/gestionStockFLD/categories') ?>" href="/gestionStockFLD/categories/listeCategorie.php">Catégories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= isActive('/gestionStockFLD/commandes') ?>" href="/gestionStockFLD/commandes/detailsCommande.php">Commandes</a>
          </li>

          <!-- Info utilisateur -->
          <?php if (!empty($_SESSION['info_utilisateurs'])): ?>
            <li class="nav-item">
              <small class="text-white"><?= htmlspecialchars($_SESSION['info_utilisateurs']) ?></small>
            </li>
          <?php endif; ?>

          <!-- Déconnexion -->
          <li class="nav-item">
            <a class="btn btn-sm btn-danger" href="/gestionStockFLD/auth/logout.php" title="Déconnexion">
              <i class="bi bi-power"></i>
            </a>
          </li>

        </ul>
      </div>
    </div>
  </nav>
</header>