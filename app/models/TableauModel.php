<?php

namespace app\models;
use Flight;
use PDO; // Assurez-vous que PDO est accessible

class TableauModel
{

    public function fetchAnimauxByUser($userId, $date)
    {
        $db = Flight::db();
        $query = "
        SELECT a.id, a.espece, s.date_achat, s.quantite, a.quota, 
               a.poids_actuel, al.pourcentage_gain,
               a.prix_vente_kg, -- Inclure le prix de vente
               LEAST(
                   a.poids_maximal,
                   (
                       a.poids_actuel 
                       - (FLOOR(DATEDIFF(:date, s.date_achat) / a.nb_jour_sans_manger) 
                       * (a.pourcentage_perte_de_poids / 100) * a.poids_actuel)
                   ) + DATEDIFF(:date, s.date_achat)
               ) AS poids_calcul
        FROM elevage_StockAnimal s
        JOIN elevage_Animaux a ON s.animal_id = a.id
        JOIN elevage_Alimentation al ON al.espece = a.espece
        WHERE s.user_id = :user_id;
    ";

        $stmt = $db->prepare($query);
        $stmt->execute(['user_id' => $userId, 'date' => $date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchStockAlimentation($userId)
    {
        $db = Flight::db();
        $query = "SELECT SUM(quantite) AS stock_aliment FROM elevage_stockAliment WHERE user_id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['stock_aliment'] ?? 0;
    }

    public function fetchAlimentsByUser($userId)
    {
        $db = Flight::db();
        $query = "
        SELECT a.id, a.nom, a.pourcentage_gain, s.quantite, s.date_achat
        FROM elevage_StockAliment s
        JOIN elevage_Alimentation a ON s.aliment_id = a.id
        WHERE s.user_id = :user_id;
    ";

        $stmt = $db->prepare($query);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function diminuerStockAlimentation($userId, $nbAnimaux)
    {
        $db = Flight::db();

        // Calcul de la consommation totale (1 kg par animal)
        $consommation = $nbAnimaux * 1;

        // Mise à jour du stock d'alimentation
        $query = "UPDATE elevage_stockAliment 
              SET quantite = GREATEST(quantite - :consommation, 0) 
              WHERE user_id = :user_id";

        $stmt = $db->prepare($query);
        $stmt->execute(['user_id' => $userId, 'consommation' => $consommation]);
    }
    public function fetchPourcentageGainByEspece($espece)
    {
        $db = Flight::db();
        $query = "
        SELECT pourcentage_gain 
        FROM elevage_Alimentation 
        WHERE espece = :espece
    ";

        $stmt = $db->prepare($query);
        $stmt->execute(['espece' => $espece]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['pourcentage_gain'] ?? 0;
    }

    public function vendreAnimal($userId, $animalId, $prix)
    {
        $db = Flight::db();



        // Retirer l'animal du stock
        $query = "DELETE FROM elevage_StockAnimal 
                  WHERE user_id = :user_id AND animal_id = :animal_id";
        $stmt = $db->prepare($query);
        $stmt->execute(['user_id' => $userId, 'animal_id' => $animalId]);
    }

    public function mettreAJourCapital($userId, $newCapital)
    {
        $db = Flight::db();
        $stmt = $db->prepare("UPDATE elevage_Users SET capital = ? WHERE id = ?");
        return $stmt->execute([$newCapital, $userId]);
    }

    public function fetchPrixVenteByEspece($espece)
    {
        $db = Flight::db();
        $query = "
        SELECT prix_vente 
        FROM elevage_Alimentation 
        WHERE espece = :espece
    ";

        $stmt = $db->prepare($query);
        $stmt->execute(['espece' => $espece]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['prix_vente'] ?? 0;
    }
}
