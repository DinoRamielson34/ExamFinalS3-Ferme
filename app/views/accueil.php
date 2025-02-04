<?php
$base_url = Flight::get('flight.base_url');

// Vérifiez si l'utilisateur a un capital défini
if ($_SESSION['user']['capital'] == null) {
    ?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Entrer le Capital</title>
        <style>
            form {
                background: #fff;
                padding: 30px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                max-width: 500px;
                margin: auto;
            }

            label,
            input[type="number"],
            input[type="submit"] {
                display: block;
                margin-bottom: 10px;
                font-size: 18px;
            }

            input[type="number"] {
                width: calc(100% - 22px);
                padding: 15px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }

            input[type="submit"] {
                background-color: #28a745;
                color: white;
                border: none;
                padding: 15px;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
                width: 100%;
            }

            input[type="submit"]:hover {
                background-color: #218838;
            }
        </style>
    </head>

    <body>
        <!-- Hero Start -->
        <div class="container-fluid bg-primary py-5 mb-5 hero-header">
            <div class="container py-5">
                <div class="row justify-content-start">
                    <div class="col-lg-8 text-center text-lg-start">
                        <h1 class="display-1 text-uppercase text-dark mb-lg-4">Pet Shop</h1>
                        <h1 class="text-uppercase text-white mb-lg-4">Make Your Pets Happy</h1>
                        <p class="fs-4 text-white mb-lg-4">Dolore tempor clita lorem rebum kasd eirmod dolore diam eos kasd.
                            Kasd clita ea justo est sed kasd erat clita sea</p>
                        <div class="d-flex align-items-center justify-content-center justify-content-lg-start pt-5">
                            <a href="" class="btn btn-outline-light border-2 py-md-3 px-md-5 me-5">Read More</a>
                            <button type="button" class="btn-play" data-bs-toggle="modal"
                                data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                                <span></span>
                            </button>
                            <h5 class="font-weight-normal text-white m-0 ms-4 d-none d-sm-block">Play Video</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->
        <form id="capitalForm" action="/update-capital" method="post">
            <label for="capital">Capital :</label>
            <input type="number" id="capital" name="capital" step="0.01" min="0" required>
            <input type="submit" value="Soumettre">
        </form>

        <script>
            document.getElementById('capitalForm').addEventListener('submit', function (event) {
                event.preventDefault();
                const capital = document.getElementById('capital').value;

                fetch('<?php echo $base_url ?>/update-capital', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ capital: capital })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Capital mis à jour avec succès !');
                            location.reload();
                        } else {
                            alert('Erreur : ' + data.message);
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
            });
        </script>
    </body>

    </html>
    <?php
    exit; // Arrête le script si le capital n'est pas défini
}

// Affichage des produits
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PET SHOP - Pet Shop Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="<?php echo $base_url ?>/public/assets/img/favicon.ico" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo $base_url ?>/public/assets/lib/flaticon/font/flaticon.css" rel="stylesheet">
    <link href="<?php echo $base_url ?>/public/assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="<?php echo $base_url ?>/public/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url ?>/public/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Hero Start -->
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-start">
                <div class="col-lg-8 text-center text-lg-start">
                    <h1 class="display-1 text-uppercase text-dark mb-lg-4">Star Breeders</h1>
                    <h1 class="text-uppercase text-white mb-lg-4">Make Your farm Happy</h1>
                    <p class="fs-4 text-white mb-lg-4">Dolore tempor clita lorem rebum kasd eirmod dolore diam eos kasd.
                        Kasd clita ea justo est sed kasd erat clita sea</p>
                    <div class="d-flex align-items-center justify-content-center justify-content-lg-start pt-5">
                        <a href="" class="btn btn-outline-light border-2 py-md-3 px-md-5 me-5">Read More</a>
                        <button type="button" class="btn-play" data-bs-toggle="modal"
                            data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                            <span></span>
                        </button>
                        <h5 class="font-weight-normal text-white m-0 ms-4 d-none d-sm-block">Play Video</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->

    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Products</h6>
                <h1 class="display-5 text-uppercase mb-0">Animals For your Farm</h1>
            </div>
            <div class="owl-carousel product-carousel">
                <?php foreach ($products as $product): ?>
                    <div class="pb-5">
                        <div class="product-item position-relative bg-light d-flex flex-column text-center">
                            <?php $photos = json_decode($product['photos']); ?>
                            <img class="img-fluid mb-4"
                                src="<?php echo $base_url ?>/public/assets/images/<?php echo $photos[0]; ?>" alt="">
                            <h6 class="text-uppercase"><?php echo htmlspecialchars($product['espece']); ?></h6>
                            <h5 class="text-primary mb-0">$<?php echo number_format($product['prix_vente_kg'], 2); ?></h5>
                            <div class="btn-action d-flex justify-content-center">
                                <a class="btn btn-primary py-2 px-3" href="#" data-id="<?php echo $product['id']; ?>"
                                    onclick="acheterAnimal(<?php echo $product['id']; ?>)">
                                    <i class="bi bi-cart"></i>
                                </a>
                                <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-eye"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- Products End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary py-3 fs-4 back-to-top"><i class="bi bi-arrow-up"></i></a>

</body>

</html>
<script>
    function acheterAnimal(animalId) {
        fetch('<?php echo $base_url ?>/acheter-animal', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ animal_id: animalId })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Afficher la boîte de dialogue de confirmation
                    afficherConfirmation(data.message);
                } else {
                    alert('Erreur : ' + data.message);
                }
            })
            .catch(error => console.error('Erreur:', error));
    }

    function afficherConfirmation(message) {
        // Créer une boîte de dialogue modale
        const modalHtml = `
        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ${message}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                        <button type="button" class="btn btn-primary" onclick="activerVenteAutomatique()">Oui</button>
                    </div>
                </div>
            </div>
        </div>
    `;

        // Ajouter la boîte de dialogue modale au corps de la page
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Afficher la boîte de dialogue
        const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        modal.show();

        // Écouter l'événement de fermeture de la modal pour le retirer du DOM
        document.getElementById('confirmationModal').addEventListener('hidden.bs.modal', function () {
            this.remove();
        });
    }

    function activerVenteAutomatique() {
        // Appeler ici la fonction pour activer la vente automatique si nécessaire
        // Logique pour activer la vente automatique peut aller ici.
        alert("Vente automatique activée !"); // Message de retour (ou logique réelle)
    }
</script>