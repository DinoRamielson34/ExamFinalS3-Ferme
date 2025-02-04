<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $base_url ?>/public/assets/css/bootstrap.css">
    <title>Ajout Alimentation</title>
</head>

<body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <form method="post" action="<?php echo $base_url ?>/ajoutAlimentation" enctype="multipart/form-data"
            class="p-4 bg-white shadow rounded" style="width: 400px;">
            <h2 class="text-center mb-4">Ajouter une Alimentation</h2>

            <div class="mb-3">
                <label for="nom" class="form-label">Nom de l'Alimentation</label>
                <input type="text" name="nom" class="form-control" id="nom" required>
            </div>

            <div class="mb-3">
                <label for="pourcentage_gain" class="form-label">Pourcentage de Gain (%)</label>
                <input type="number" name="pourcentage_gain" class="form-control" id="pourcentage_gain" step="0.01"
                    required>
            </div>

            <div class="mb-3">
                <label for="espece" class="form-label">Espèce</label>
                <select name="espece" class="form-control" id="espece" required>
                    <option value="" disabled selected>Choisir une espèce</option>
                    <?php foreach ($animaux as $animal): ?>
                        <option value="<?php echo htmlspecialchars($animal['espece']); ?>">
                            <?php echo htmlspecialchars($animal['espece']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="pourcentage_gain" class="form-label">Prix</label>
                <input type="number" name="prix" class="form-control" id="prix" step="1" required>
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