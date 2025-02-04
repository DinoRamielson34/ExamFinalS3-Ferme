<?php
$base_url = Flight::get('flight.base_url');
if ($_SESSION['user']['role'] == 'admin') {
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/public/assets/css/liste.css">
    <link rel="stylesheet" href="<?php echo $base_url ?>/public/assets/css/bootstrap.css">

    <title>Liste animal</title>
  </head>

  <body>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Image</th>
          <th scope="col">Espece</th>
          <th scope="col">Poids Minimal Vente</th>
          <th scope="col">Prix Vente/Kg</th>
          <th scope="col">Poids Maximal</th>
          <th scope="col">Nb Jour Sans Manger</th>
          <th scope="col">Pourcentage Perte de Poids</th>
          <th scope="col">Poids Actuel</th>
          <th scope="col">Date d'Achat</th>
          <th scope="col">Quota Journalier</th>
          <th><a href="<?php echo $base_url ?>/form_ajout"><button type="button" class="btn btn-info">Ajouter nouveau
                animal</button></a></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($animaux as $animal): ?>
          <tr>
            <td>
              <img
                src="<?php echo $base_url . '/public/assets/images/' . htmlspecialchars(json_decode($animal['photos'])[0]); ?>"
                alt="" style="width: 100px; height: auto;">
            </td>
            <td><?php echo $animal['espece']; ?></td>
            <td><?php echo $animal['poids_minimal_vente']; ?></td>
            <td><?php echo $animal['prix_vente_kg']; ?></td>
            <td><?php echo $animal['poids_maximal']; ?></td>
            <td><?php echo $animal['nb_jour_sans_manger']; ?></td>
            <td><?php echo $animal['pourcentage_perte_de_poids']; ?></td>
            <td><?php echo $animal['poids_actuel']; ?></td>
            <td><?php echo $animal['date_achat']; ?></td>
            <td><?php echo $animal['quota']; ?></td>
            <td>
              <div class="actions">
                <a href="<?php echo $base_url ?>/modification?idAnimal=<?php echo $animal['id'] ?>"><img
                    src="<?php echo $base_url . '/public/assets/images/stylo.png' ?>" alt=""></a>
                <a href="<?php echo $base_url ?>/suppression?idAnimal=<?php echo $animal['id'] ?>"><img
                    src="<?php echo $base_url . '/public/assets/images/supprimer.png' ?>" alt=""></a>
              </div>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </body>

  </html>
<?php } else {
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>

  <body>
    <h1>Vous n'ête pas autorisé à entrer ici</h1>
  </body>

  </html>
<?php } ?>