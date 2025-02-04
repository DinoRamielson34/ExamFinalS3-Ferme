<?php

namespace app\models;

use Flight;
use PDO;

class HomeModel
{
    public function getProperties()
    {
        $db = Flight::db();
        $stmt = $db->query("SELECT * FROM properties");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}