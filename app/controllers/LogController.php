<?php

namespace app\controllers;

use app\models\ProductModel;
use app\models\LogModel;
use Flight;

class LogController
{

    public function __construct()
    {

    }
    public function login()
    {
        $data = [
            'page' => 'login_form',
        ];

        Flight::render('log', $data);
    }
    public function log()
    {
        // Récupérer les données POST du formulaire de connexion
        $db = Flight::db();
        $email = Flight::request()->data->email;
        $password = Flight::request()->data->password;

        // Vérifier si les champs ne sont pas vides
        if (empty($email) || empty($password)) {
            Flight::redirect('/');
            return;
        }

        // Récupérer le modèle utilisateur pour vérifier les informations de connexion
        $userModel = new LogModel($db);
        $user = $userModel->getUserByEmail($email);

        // Afficher pour déboguer
        var_dump($user); // Vérifiez ce qui est retourné par getUserByEmail

        // Vérifier si l'utilisateur existe
        if ($user === false) {
            // Gérer le cas où l'utilisateur n'est pas trouvé
            error_log("User not found for email: " . $email); // Journaliser l'email qui a échoué
            Flight::redirect('/');
            return;
        }

        // Vérifier si le mot de passe est correct
        if ($password === $user['password']) {
            // Démarrer la session si ce n'est pas déjà fait
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // Enregistrer toutes les données de l'utilisateur dans la session
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['name'],
                'phone' => $user['phone'],
                'role' => $user['role'],
                'capital' => $user['capital'],
                // Ajoutez d'autres données utilisateur si nécessaire
            ];

            Flight::redirect('/home');
        } else {
            // Journaliser le cas où le mot de passe est incorrect
            error_log("Incorrect password for email: " . $email);
            Flight::redirect('/');
        }
    }

    public function register()
    {
        $db = Flight::db();
        $name = Flight::request()->data->names;
        $email = Flight::request()->data->email;
        $password = Flight::request()->data->password;
        $phone = Flight::request()->data->phone;

        // Vérification si l'inscription est pour un admin
        $isAdmin = isset(Flight::request()->data->is_admin) ? 1 : 0;

        $logModel = new LogModel($db);

        if (empty($name) || empty($email) || empty($password) || empty($phone)) {
            Flight::set('flash', 'Tous les champs sont requis.');
            Flight::redirect('/');
            return;
        }

        if ($logModel->getUserByEmail($email)) {
            Flight::set('flash', 'Cet email est déjà utilisé.');
            Flight::redirect('/');
            return;
        }

        // Enregistrement avec rôle
        if ($logModel->registerUser($name, $email, $password, $phone, $isAdmin)) {
            Flight::set('flash', 'Inscription réussie, veuillez vous connecter.');
            Flight::redirect('/');
        } else {
            Flight::set('flash', 'Erreur lors de l\'inscription. Veuillez réessayer.');
            Flight::redirect('/');
        }
    }








    public function home(
    ) {
        $produit = Flight::productModel()->getProduit();
        $data = ['nom' => $produit["nom"], 'prix' => $produit["prix"]];
        Flight::render('welcome', $data);
    }
    public function homeDB()
    {
        $produit = Flight::productModel()->test();
        $data = ['nom' => $produit["nom"], 'prix' => $produit["date_naissance"]];
        Flight::render('welcome', $data);
    }

    public function testDB()
    {
        $productModel = new ProductModel(Flight::db());
        $produit = $productModel->test();
        $data = ['nom' => $produit["nom"], 'prix' => $produit["date_naissance"]];
        Flight::render('welcome', $data);
    }

    //pour tester le template
    public function homeTemplate()
    {
        $data = ['page' => "home"];
        Flight::render('template', $data);
    }

    //pour tester le template
    public function productTemplate()
    {
        $data = ['page' => "product"];
        Flight::render('template', $data);
    }
}