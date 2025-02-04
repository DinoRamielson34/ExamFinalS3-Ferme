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

    <title>Liste des Alimentations</title>
  </head>

  <body>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">Images</th>
          <th scope="col">Nom</th>
          <th scope="col">Pourcentage Gain</th>
          <th scope="col">Espèce</th>
          <th scope="col">Prix</th>
          <th><a href="<?php echo $base_url ?>/form_ajoutAlimentation"><button type="button" class="btn btn-info">Ajouter
                nouvelle alimentation</button></a></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($alimentations as $alimentation): ?>
          <tr>
            <td>
              <?php if (!empty($alimentation['photos'])): ?>
                <img
                  src="<?php echo $base_url . '/public/assets/images/' . htmlspecialchars(json_decode($alimentation['photos'])[0]); ?>"
                  alt="" style="width: 100px; height: auto;">
              <?php else: ?>
                Pas d'image
              <?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($alimentation['nom']); ?></td>
            <td><?php echo htmlspecialchars($alimentation['pourcentage_gain']); ?>%</td>
            <td><?php echo htmlspecialchars($alimentation['espece']); ?></td>
            <td><?php echo htmlspecialchars($alimentation['prix']); ?>Ar</td>
            <td>
              <div class="actions">
                <a href="<?php echo $base_url ?>/modificationAlimentation?idAlimentation=<?php echo $alimentation['id'] ?>"><img
                    src="<?php echo $base_url . '/public/assets/images/stylo.png' ?>" alt=""></a>
                <a href="<?php echo $base_url ?>/suppressionAlimentation?idAlimentation=<?php echo $alimentation['id'] ?>"><img
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