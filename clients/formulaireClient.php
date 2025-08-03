<!-- Bootstrap CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<div class="container mt-5">
    <div class="card shadow p-4 mx-auto" style="max-width: 600px;">
        <h4 class="text-center mb-4">Formulaire d’ajout de client</h4>

        <form action="addClient.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nom" class="form-label">Prénom et Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>

            <!-- <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div> -->

            <!-- <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="adresse" name="adresse" required>
            </div> -->

            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="tel" class="form-control" id="telephone" name="telephone" required>
            </div>

            <div class="mb-3">
                <label for="telephone" class="form-label">Email</label>
                <input type="email" class="form-control" id="telephone" name="email" required>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Photo du client</label>
                <input type="file" class="form-control" name="photo" id="photo" accept="image/*">
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Ajouter le client</button>
                <a href="index.php" class="btn btn-outline-secondary">← Retour à la liste</a>
            </div>
        </form>
    </div>
</div>
