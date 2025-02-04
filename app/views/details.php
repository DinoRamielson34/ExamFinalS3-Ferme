<?php
$base_url = Flight::get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/public/assets/css/details.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/public/assets/css/bootstrap.css">
    <title>Details habitation</title>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <?php foreach($habitations as $habitation): ?>
            <article class="product">
                <!-- Galerie d'images -->
                <div class="image-gallery">
                    <?php 
                    $photos = json_decode($habitation['photos']);
                    foreach ($photos as $index => $photo): ?>
                        <div class="image-item">
                            <img src="<?php echo $base_url . '/public/assets/images/' . htmlspecialchars($photo); ?>"
                                 alt="Image <?php echo $index + 1; ?>" class="gallery-image" onclick="zoomImage(this)">
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Description de l'habitation -->
                <div class="mt-3">
                    <h2><?php echo htmlspecialchars($habitation['type']); ?></h2>
                    <p><?php echo htmlspecialchars($habitation['description']); ?></p>
                    <p>Prix : <?php echo htmlspecialchars($habitation['loyer']); ?> Ar</p>
                </div>
            </article>
        </div>

        <div class="col-md-4">
            <!-- Formulaire aligné à droite -->
            <div class="d-flex justify-content-end align-items-center">
                <form method="post" action="<?php echo $base_url?>/reservation" enctype="multipart/form-data" class="p-4 bg-white shadow rounded" style="width: 100%;">
                    <h2>Reservation</h2>
                    <div class="mb-3">
                        <label for="dateArrive" class="form-label">Date d'arrivée</label>
                        <input type="date" name="dateArrive" class="form-control" id="dateArrive" required>
                    </div>

                    <!-- Date de départ -->
                    <div class="mb-3">
                        <label for="dateDepart" class="form-label">Date de départ</label>
                        <input type="date" name="dateDepart" class="form-control" id="dateDepart" required>
                    </div>

                    <!-- Nombre de voyageurs -->
                    <div class="mb-3">
                        <label for="nbVoyageurs" class="form-label">Nombre de voyageurs</label>
                        <input type="number" name="nbVoyageurs" class="form-control" id="nbVoyageurs" min="1" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Valider</button>
                </form>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>

</body>
</html>
