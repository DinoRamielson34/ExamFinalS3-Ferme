<?php
$base_url = Flight::get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $base_url ?>/public/assets/css/bootstrap.css">
    <title>Ajout Animal</title>
</head>

<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <form method="post" action="<?php echo $base_url ?>/ajout" enctype="multipart/form-data"
            class="p-4 bg-white shadow rounded" style="width: 400px;">
            <h2 class="text-center mb-4">Ajouter un Animal</h2>

            <div class="mb-3">
                <label for="espece" class="form-label">Espèce</label>
                <input type="text" name="espece" class="form-control" id="espece" required>
            </div>

            <div class="mb-3">
                <label for="poids_minimal_vente" class="form-label">Poids Minimal Vente (kg)</label>
                <input type="number" name="poids_minimal_vente" class="form-control" id="poids_minimal_vente"
                    step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="prix_vente_kg" class="form-label">Prix Vente par kg (€)</label>
                <input type="number" name="prix_vente_kg" class="form-control" id="prix_vente_kg" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="poids_maximal" class="form-label">Poids Maximal (kg)</label>
                <input type="number" name="poids_maximal" class="form-control" id="poids_maximal" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="nb_jour_sans_manger" class="form-label">Nombre de Jours sans Manger</label>
                <input type="number" name="nb_jour_sans_manger" class="form-control" id="nb_jour_sans_manger" required>
            </div>

            <div class="mb-3">
                <label for="pourcentage_perte_de_poids" class="form-label">Perte de Poids (%)</label>
                <input type="number" name="pourcentage_perte_de_poids" class="form-control"
                    id="pourcentage_perte_de_poids" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="poids_actuel" class="form-label">Poids Actuel (kg)</label>
                <input type="number" name="poids_actuel" class="form-control" id="poids_actuel" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="date_achat" class="form-label">Date d'Achat</label>
                <input type="date" name="date_achat" class="form-control" id="date_achat" required>
            </div>
            <div class="mb-3">
                <label for="quota" class="form-label">Quota Journalier</label>
                <input type="number" name="quota" class="form-control" id="quota" required>
            </div>

            <div class="mb-3">
                <label for="photos" class="form-label">Upload Photos</label>
                <input type="file" name="photos[]" class="form-control" id="photos" multiple
                    accept=".png,.jpg,.jpeg,.gif" required>
                <div class="form-text">Formats acceptés : .png, .jpg, .jpeg, .gif</div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Ajouter</button>
        </form>
    </div>
</body>

</html>