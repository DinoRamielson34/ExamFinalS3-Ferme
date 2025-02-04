<?php
session_start();
require_once 'path/to/your/autoload.php'; // Mettez à jour ce chemin

use app\controllers\TableauController;

$tableauController = new TableauController();
$tableauController->getSituationElevage(); // Cette méthode doit renvoyer les données au format JSON