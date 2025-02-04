<?php

namespace app\controllers;

use app\models\ProductModel;
use app\models\LogModel;
use app\models\AccueilModel;
use Flight;

class AccueilController
{

    public function __construct()
    {

    }

    public function home()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $homeModel = new AccueilModel();
        $products = $homeModel->getProducts(); // Récupérer les produits

        $data = [
            'page' => 'accueil',
            'user' => $_SESSION['user'],
            'products' => $products // Passer les produits à la vue
        ];

        Flight::render('template', $data);
    }

    public function updateCapital()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $db = Flight::db();
        $capital = Flight::request()->data->capital;

        // Vérifiez si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            Flight::json(['success' => false, 'message' => 'Utilisateur non connecté.']);
            return;
        }

        $userId = $_SESSION['user']['id'];

        // Mettre à jour le capital dans la base de données
        $stmt = $db->prepare("UPDATE elevage_Users SET capital = ? WHERE id = ?");
        $success = $stmt->execute([$capital, $userId]);

        if ($success) {
            // Mettre à jour la session
            $_SESSION['user']['capital'] = $capital;
            Flight::json(['success' => true]);
        } else {
            Flight::json(['success' => false, 'message' => 'Échec de la mise à jour.']);
        }
    }

    public function checkCapital()
    {
        // Vérifiez si la session est active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifiez si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            Flight::json(['success' => false, 'message' => 'Utilisateur non connecté.']);
            return;
        }

        $data = Flight::request()->data->getData();

        // Utilisez des crochets pour accéder à price car c'est probablement un tableau
        $price = $data['price'];  // Remplacez -> par []

        $capital = $_SESSION['user']['capital'];

        if ($capital >= $price) {
            Flight::json(['success' => true]);
        } else {
            Flight::json(['success' => false, 'message' => 'Votre capital est insuffisant.']);
        }
    }
    public function buyProduct()
    {
        if (!isset($_SESSION['user'])) {
            Flight::json(['success' => false, 'message' => 'Utilisateur non connecté.']);
            return;
        }

        $productId = Flight::request()->data->productId;
        $db = Flight::db();

        // Récupérer le prix du produit
        $stmt = $db->prepare("SELECT prix_vente_kg FROM elevage_Animaux WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            Flight::json(['success' => false, 'message' => 'Produit introuvable.']);
            return;
        }

        $price = $product['prix_vente_kg'];

        // Vérifier et mettre à jour le capital
        $currentCapital = $_SESSION['user']['capital'];
        if ($currentCapital < $price) {
            Flight::json(['success' => false, 'message' => 'Capital insuffisant.']);
            return;
        }

        // Mettre à jour le capital de l'utilisateur
        $newCapital = $currentCapital - $price;
        $stmt = $db->prepare("UPDATE elevage_Users SET capital = ? WHERE id = ?");
        $stmt->execute([$newCapital, $_SESSION['user']['id']]);

        // Enregistrer l'achat dans elevage_StockAnimal
        $stmt = $db->prepare("INSERT INTO elevage_StockAnimal (user_id, animal_id, quantite, date_achat) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$_SESSION['user']['id'], $productId, 1]); // Ajout d'une unité

        // Mettre à jour la session
        $_SESSION['user']['capital'] = $newCapital;

        // Message de succès avec demande d'activation de vente automatique
        Flight::json(['success' => true, 'message' => 'Achat réussi ! Souhaitez-vous activer la vente automatique ?']);
    }
}