<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tableau de Bord Élevage</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container mt-4">
        <h2>Votre capital : <?php echo $_SESSION['user']['capital'] ?> Ar</h2>
        <h2 class="mb-4">Tableau de Bord Élevage</h2>
        <div class="d-flex mb-4">
            <input type="date" class="form-control w-auto me-2" id="date_jour">
            <button class="btn btn-primary" id="btn_simuler">Simuler</button>
        </div>

        <div class="row g-4" id="stats"></div>

        <h4 class="mt-3">Mes Animaux</h4>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Espèce</th>
                    <th>Poids Calculé (kg)</th>
                    <th>Date d'Achat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="table_data"></tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            function chargerSituation(date) {
                $.ajax({
                    url: "<?php echo $base_url ?>/getSituationElevage",
                    type: "GET",
                    data: { date: date },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (!response || typeof response !== "object") {
                            console.error("Réponse invalide:", response);
                            return;
                        }

                        let nbAnimaux = response.nb_animaux ?? 0;
                        let stockAlimentation = response.alimentation_stock ?? 0;
                        let animaux = response.animaux ?? [];

                        $("#stats").html(`
                            <div class="col-md-4">
                                <div class="card text-bg-primary">
                                    <div class="card-body">
                                        <h5 class="card-title">Nombre d'Animaux</h5>
                                        <p class="card-text fs-3">${nbAnimaux}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-bg-success">
                                    <div class="card-body">
                                        <h5 class="card-title">Alimentation Restante</h5>
                                        <p class="card-text fs-3">${stockAlimentation} kg</p>
                                    </div>
                                </div>
                            </div>
                        `);

                        let tableContent = "";
                        if (animaux.length > 0) {
                            animaux.forEach((animal, index) => {
                                let imageUrl = ""; // Déclaration en dehors des conditions

                                if (animal.espece === "Boeuf") {
                                    imageUrl = "<?php echo $base_url; ?>/public/assets/images/boeuf.jpg"; // Image pour Boeuf
                                } else if (animal.espece === "Porc") {
                                    imageUrl = "<?php echo $base_url; ?>/public/assets/images/porc.jpg"; // Image pour Porc
                                } else if (animal.espece === "Poule") {
                                    imageUrl = "<?php echo $base_url; ?>/public/assets/images/poule.jpg"; // Image pour Poule
                                } else if (animal.espece === "Canard") {
                                    imageUrl = "<?php echo $base_url; ?>/public/assets/images/canard.jpg"; // Image pour Canard
                                } else if (animal.espece === "Lapin") {
                                    imageUrl = "<?php echo $base_url; ?>/public/assets/images/lapin.jpg"; // Image pour Lapin
                                } else {
                                    imageUrl = "<?php echo $base_url; ?>/public/assets/images/boeuf2.jpg"; // Image par défaut
                                }


                                tableContent += `
                                    <tr>
                                        <td><img src="${imageUrl}" alt="Animal" width="150"></td>
                                        <td>${animal.espece}</td>
                                        <td>${(animal.poids_calcul ?? 0)}</td>
                                        <td>${animal.date_achat ?? "Non défini"}</td>
                                        <td>
                                            <button class="btn btn-danger btn-vendre" 
                                                    data-animal-id="${animal.id}" 
                                                    data-poids="${animal.poids_actuel}" 
                                                    data-prix-vente="${animal.prix_vente_kg}">
                                                Vendre
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            });
                        } else {
                            tableContent = `
                                <tr>
                                    <td colspan="5" class="text-center">Aucun animal trouvé</td>
                                </tr>
                            `;
                        }
                        $("#table_data").html(tableContent);
                    },
                    error: function (xhr, status, error) {
                        console.error("Erreur AJAX:", error);
                        alert("Une erreur est survenue lors de la récupération des données.");
                    }
                });
            }

            $(document).on("click", ".btn-vendre", function () {
                const animalId = $(this).data("animal-id");
                const poidsActuel = parseFloat($(this).data("poids")); // Convertir en float
                const prixVenteKg = parseFloat($(this).data("prix-vente")); // Convertir en float

                console.log("Poids Actuel:", poidsActuel, "Prix Vente Kg:", prixVenteKg, poidsActuel * prixVenteKg); // Debug

                // Calculer le prix de vente
                const prixTotal = poidsActuel * prixVenteKg;

                if (isNaN(prixTotal)) {
                    alert("Erreur de calcul du prix total. Vérifiez les valeurs.");
                    return;
                }

                if (confirm("Êtes-vous sûr de vouloir vendre cet animal ? Prix de vente: " + prixTotal + " Ar")) {
                    // Effectuer une requête AJAX pour vendre l'animal
                    $.ajax({
                        url: "<?php echo $base_url ?>/vendreAnimal",
                        type: "POST",
                        data: { id: animalId, prix: prixTotal },
                        success: function (response) {
                            alert("Animal vendu avec succès !");
                            chargerSituation($("#date_jour").val()); // Recharger la situation
                        },
                        error: function (xhr, status, error) {
                            console.error("Erreur lors de la vente de l'animal:", error);
                            alert("Une erreur est survenue lors de la vente de l'animal.");
                        }
                    });
                }
            });

            $("#btn_simuler").on("click", function () {
                let selectedDate = $("#date_jour").val();
                chargerSituation(selectedDate);
            });

            // Charger la situation initiale avec la date du jour
            let today = new Date().toISOString().split("T")[0];
            $("#date_jour").val(today);
            chargerSituation(today);
        });
    </script>
</body>

</html>