<?php

namespace app\controllers;

use app\models\TableauModel;
use Flight;

class TableauController
{
    private $tableauModel;


    public function tableauDeBord()
    {
        $data = [
            'page' => 'tableauBord',
        ];

        Flight::render('template', $data);
    }

    public function getSituationElevage()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'];
        $date = $_GET['date'] ?? date('Y-m-d');

        $tableauModel = new TableauModel();
        $animaux = $tableauModel->fetchAnimauxByUser($userId, $date);
        $stockAliment = $tableauModel->fetchStockAlimentation($userId);
        $nbAnimaux = count($animaux);
        $consommationTotale = 0;

        // Calculez la consommation totale et le gain de poids
        foreach ($animaux as &$animal) {
            $quota = $animal['quota'];

            // Récupérer le pourcentage de gain pour l'espèce de l'animal
            $pourcentageGain = $tableauModel->fetchPourcentageGainByEspece($animal['espece']);

            // Calculer le gain de poids
            $gainPoids = ($quota * ($pourcentageGain / 100));

            // Mettre à jour le poids actuel
            $animal['poids_actuel'] += $gainPoids;
            $consommationTotale += $quota; // Totaliser la consommation pour le stock d'alimentation
        }

        $_SESSION['alimentation_stock'] = $stockAliment; // Assurer l'affichage de la valeur initiale

        // Vérifier si la date a déjà été simulée pour éviter plusieurs diminutions
        if (!isset($_SESSION['last_simulated_date']) || $_SESSION['last_simulated_date'] !== $date) {
            $_SESSION['alimentation_stock'] = max($_SESSION['alimentation_stock'] - $consommationTotale, 0);
            $_SESSION['last_simulated_date'] = $date;
        }

        Flight::json([
            'nb_animaux' => $nbAnimaux,
            'alimentation_stock' => $_SESSION['alimentation_stock'] ?? $stockAliment,
            'animaux' => $animaux
        ]);
    }

    public function vendreAnimal()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'];
        $animalId = $_POST['id'];
        $prix = (float) $_POST['prix']; // Convertir le prix en float

        $tableauModel = new TableauModel();
        $tableauModel->vendreAnimal($userId, $animalId, $prix); // Appel de la méthode pour vendre l'animal

        $capital = (float) $_SESSION['user']['capital']; // Convertir le capital en float
        $newCapital = $capital + $prix;

        $tableauModel->mettreAJourCapital($userId, $newCapital);

        Flight::json(['success' => true, 'prix' => $prix]);
    }
}

