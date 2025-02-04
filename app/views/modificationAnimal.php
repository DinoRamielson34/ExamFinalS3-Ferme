<?php
$base_url = Flight::get('flight.base_url');

// Supposons que $animal contienne les données actuelles de l'animal récupérées depuis la base
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $base_url ?>/public/assets/css/bootstrap.css">
    <title>Modifier un Animal</title>
</head>

<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <form method="post" action="<?php echo $base_url ?>/modifierAnimal" enctype="multipart/form-data"
            class="p-4 bg-white shadow rounded" style="width: 400px;">
            <h2 class="text-center mb-4">Modifier un Animal</h2>

            <input type="hidden" name="id_animal" value="<?php echo htmlspecialchars($animal['id']); ?>">

            <div class="mb-3">
                <label for="espece" class="form-label">Espèce</label>
                <input type="text" name="espece" class="form-control" id="espece"
                    value="<?php echo htmlspecialchars($animal['espece']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="poids_minimal_vente" class="form-label">Poids Minimal Vente (kg)</label>
                <input type="number" name="poids_minimal_vente" class="form-control" id="poids_minimal_vente"
                    value="<?php echo htmlspecialchars($animal['poids_minimal_vente']); ?>" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="prix_vente_kg" class="form-label">Prix Vente par kg (€)</label>
                <input type="number" name="prix_vente_kg" class="form-control" id="prix_vente_kg"
                    value="<?php echo htmlspecialchars($animal['prix_vente_kg']); ?>" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="poids_maximal" class="form-label">Poids Maximal (kg)</label>
                <input type="number" name="poids_maximal" class="form-control" id="poids_maximal"
                    value="<?php echo htmlspecialchars($animal['poids_maximal']); ?>" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="nb_jour_sans_manger" class="form-label">Nombre de Jours sans Manger</label>
                <input type="number" name="nb_jour_sans_manger" class="form-control" id="nb_jour_sans_manger"
                    value="<?php echo htmlspecialchars($animal['nb_jour_sans_manger']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="pourcentage_perte_de_poids" class="form-label">Perte de Poids (%)</label>
                <input type="number" name="pourcentage_perte_de_poids" class="form-control"
                    id="pourcentage_perte_de_poids"
                    value="<?php echo htmlspecialchars($animal['pourcentage_perte_de_poids']); ?>" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="poids_actuel" class="form-label">Poids Actuel (kg)</label>
                <input type="number" name="poids_actuel" class="form-control" id="poids_actuel"
                    value="<?php echo htmlspecialchars($animal['poids_actuel']); ?>" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="date_achat" class="form-label">Date d'Achat</label>
                <input type="date" name="date_achat" class="form-control" id="date_achat"
                    value="<?php echo htmlspecialchars($animal['date_achat']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="quota" class="form-label">Quota Journalier</label>
                <input type="number" name="quota" class="form-control" id="quota"
                    value="<?php echo htmlspecialchars($animal['quota']); ?>" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="photos" class="form-label">Changer les photos (optionnel)</label>
                <input type="file" name="photos[]" class="form-control" id="photos" multiple
                    accept=".png,.jpg,.jpeg,.gif">
                <div class="form-text">Formats acceptés : .png, .jpg, .jpeg, .gif</div>
            </div>

            <button type="submit" class="btn btn-success w-100">Mettre à jour</button>
        </form>
    </div>
</body>

</html>