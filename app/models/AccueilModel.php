<?php

namespace app\models;

use Flight;
use PDO;

class AccueilModel
{
    public function getProducts()
    {
        $db = Flight::db();
        $stmt = $db->query("SELECT * FROM elevage_Animaux");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}