<?php
$base_url = Flight::get('flight.base_url');

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $base_url ?>/public/assets/css/bootstrap.css">
    <title>Modifier une Alimentation</title>
</head>

<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <form method="post" action="<?php echo $base_url ?>/modifierAlimentation" enctype="multipart/form-data"
            class="p-4 bg-white shadow rounded" style="width: 400px;">
            <h2 class="text-center mb-4">Modifier une Alimentation</h2>

            <input type="hidden" name="id_alimentation" value="<?php echo htmlspecialchars($alimentation['id']); ?>">

            <div class="mb-3">
                <label for="nom" class="form-label">Nom de l'Alimentation</label>
                <input type="text" name="nom" class="form-control" id="nom"
                    value="<?php echo htmlspecialchars($alimentation['nom']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="pourcentage_gain" class="form-label">Pourcentage de Gain</label>
                <input type="number" name="pourcentage_gain" class="form-control" id="pourcentage_gain"
                    value="<?php echo htmlspecialchars($alimentation['pourcentage_gain']); ?>" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="espece" class="form-label">Espèce</label>
                <input type="text" name="espece" class="form-control" id="espece"
                    value="<?php echo htmlspecialchars($alimentation['espece']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="prix" class="form-label">Prix</label>
                <input type="number" name="prix" class="form-control" id="pourcentage_gain"
                    value="<?php echo htmlspecialchars($alimentation['prix']); ?>" step="0.01" required>
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