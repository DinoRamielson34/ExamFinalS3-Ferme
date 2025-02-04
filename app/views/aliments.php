<?php
$base_url = Flight::get('flight.base_url');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/public/assets/css/liste.css">
    <link rel="stylesheet" href="<?php echo $base_url ?>/public/assets/css/bootstrap.css">

    <title>Liste des Alimentations</title>
</head>

<body>
    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Alimentations</h6>
                <h1 class="display-5 text-uppercase mb-0">Liste des Alimentations</h1>
            </div>
            <div class="row">
                <?php foreach ($alimentations as $alimentation): ?>
                    <div class="col-lg-4 col-md-6 pb-5">
                        <div class="product-item position-relative bg-light d-flex flex-column text-center">
                            <?php $photos = json_decode($alimentation['photos']); ?>
                            <img class="img-fluid mb-4"
                                src="<?php echo $base_url ?>/public/assets/images/<?php echo $photos[0]; ?>" alt="">
                            <h6 class="text-uppercase"><?php echo htmlspecialchars($alimentation['nom']); ?></h6>
                            <h5 class="text-primary mb-0">Gain:
                                <?php echo number_format($alimentation['pourcentage_gain'], 2); ?>%
                            </h5>
                            <h5 class="text-primary mb-0">Espèce: <?php echo htmlspecialchars($alimentation['espece']); ?>
                            </h5>
                            <div class="btn-action d-flex justify-content-center">
                                <a class="btn btn-primary py-2 px-3" href="#" data-id="<?php echo $alimentation['id']; ?>"
                                    onclick="acheterAliment(<?php echo $alimentation['id']; ?>)">
                                    <i class="bi bi-cart"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- Products End -->
</body>
<script>
    function acheterAliment(alimentId) {
        const quantite = prompt("Entrez la quantité souhaitée:", "1");
        if (quantite === null || isNaN(quantite) || quantite <= 0) {
            alert("Veuillez entrer une quantité valide.");
            return;
        }

        fetch('<?php echo $base_url ?>/acheter-aliment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ aliment_id: alimentId, quantite: parseInt(quantite) })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload(); // Recharger la page pour mettre à jour l'état
                } else {
                    alert('Erreur : ' + data.message);
                }
            })
            .catch(error => console.error('Erreur:', error));
    }
</script>

</html>