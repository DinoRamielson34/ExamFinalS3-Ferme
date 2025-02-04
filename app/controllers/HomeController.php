<?php

namespace app\controllers;

use app\models\ProductModel;
use app\models\LogModel;
use app\models\HomeModel; // Import the HomeModel
use Flight;

class Homecontroller
{
    public function home()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $homeModel = new HomeModel();
        $properties = $homeModel->getProperties(); // Fetch properties

        $data = [
            'page' => 'home',
            'user' => $_SESSION['user'],
            'properties' => $properties // Add properties to data
        ];

        Flight::render('template', $data);
    }
}