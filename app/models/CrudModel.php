<?php

namespace app\models;

use Flight;
use PDO;

class CrudModel
{

    // Lister tous les animaux
    public function listerAnimaux()
    {
        $db = Flight::db();
        $stmt = $db->query("SELECT * FROM elevage_Animaux");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Ajouter un animal au stock
    public function ajouterStockAnimal($userId, $animalId, $quantite)
    {
        $db = Flight::db();
        $stmt = $db->prepare("INSERT INTO elevage_StockAnimal (user_id, animal_id, quantite, date_achat) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$userId, $animalId, $quantite]);
    }

    // Mettre à jour le capital d'un utilisateur
    public function mettreAJourCapital($userId, $newCapital)
    {
        $db = Flight::db();
        $stmt = $db->prepare("UPDATE elevage_Users SET capital = ? WHERE id = ?");
        return $stmt->execute([$newCapital, $userId]);
    }
    // Ajouter un animal
    public function ajouterAnimal($espece, $poids_minimal_vente, $prix_vente_kg, $poids_maximal, $nb_jour_sans_manger, $pourcentage_perte_de_poids, $poids_actuel, $date_achat, $quota, $photos)
    {
        $db = Flight::db();

        $stmt = $db->prepare("INSERT INTO elevage_Animaux (espece, poids_minimal_vente, prix_vente_kg, poids_maximal, nb_jour_sans_manger, pourcentage_perte_de_poids, poids_actuel, date_achat, quota, photos) 
                                  VALUES (:espece, :poids_minimal_vente, :prix_vente_kg, :poids_maximal, :nb_jour_sans_manger, :pourcentage_perte_de_poids, :poids_actuel, :date_achat, :quota , :photos)");
        $result = $stmt->execute([
            ':espece' => $espece,
            ':poids_minimal_vente' => $poids_minimal_vente,
            ':prix_vente_kg' => $prix_vente_kg,
            ':poids_maximal' => $poids_maximal,
            ':nb_jour_sans_manger' => $nb_jour_sans_manger,
            ':pourcentage_perte_de_poids' => $pourcentage_perte_de_poids,
            ':poids_actuel' => $poids_actuel,
            ':date_achat' => $date_achat,
            'quota' => $quota,
            ':photos' => $photos
        ]);

        if (!$result) {
            var_dump($stmt->errorInfo());
            return false;
        }

        return true;
    }
    public function ajouterStockAlimentation($userId, $alimentId, $quantite)
    {
        $db = Flight::db();
        $stmt = $db->prepare("INSERT INTO elevage_stockaliment (user_id, aliment_id, quantite, date_achat) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([$userId, $alimentId, $quantite]);
    }

    // Modifier un animal
    public function modifierAnimal($id, $espece, $poids_minimal_vente, $prix_vente_kg, $poids_maximal, $nb_jour_sans_manger, $pourcentage_perte_de_poids, $poids_actuel, $date_achat, $quota, $photos)
    {
        $db = Flight::db();

        $stmt = $db->prepare("UPDATE elevage_Animaux 
                                  SET espece = :espece, poids_minimal_vente = :poids_minimal_vente, prix_vente_kg = :prix_vente_kg, 
                                      poids_maximal = :poids_maximal, nb_jour_sans_manger = :nb_jour_sans_manger, 
                                      pourcentage_perte_de_poids = :pourcentage_perte_de_poids, poids_actuel = :poids_actuel, 
                                      date_achat = :date_achat,quota = :quota,  photos = :photos 
                                  WHERE id = :id");

        $result = $stmt->execute([
            ':id' => $id,
            ':espece' => $espece,
            ':poids_minimal_vente' => $poids_minimal_vente,
            ':prix_vente_kg' => $prix_vente_kg,
            ':poids_maximal' => $poids_maximal,
            ':nb_jour_sans_manger' => $nb_jour_sans_manger,
            ':pourcentage_perte_de_poids' => $pourcentage_perte_de_poids,
            ':poids_actuel' => $poids_actuel,
            ':date_achat' => $date_achat,
            ':quota' => $quota,
            ':photos' => $photos
        ]);

        if (!$result) {
            var_dump($stmt->errorInfo());
            return false;
        }

        return true;
    }

    // Supprimer un animal
    public function supprimerAnimal($id)
    {
        $db = Flight::db();
        $stmt = $db->prepare("DELETE FROM elevage_Animaux WHERE id = :id");
        $result = $stmt->execute([':id' => $id]);

        if (!$result) {
            var_dump($stmt->errorInfo());
            return false;
        }

        return true;
    }

    public function GetAnimalById($idAnimal)
    {
        $db = Flight::db(); // Récupération de l'instance de la base de données
        $sql = "SELECT * FROM elevage_Animaux WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$idAnimal]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne l'animal sous forme de tableau associatif
    }


    public function listerAlimentations()
    {
        $db = Flight::db();
        $stmt = $db->query("SELECT * FROM elevage_Alimentation");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ajouterAlimentation($nom, $pourcentage_gain, $espece, $prix, $photos)
    {
        $db = Flight::db();

        $stmt = $db->prepare("INSERT INTO elevage_Alimentation (nom, pourcentage_gain, espece, prix, photos) 
                                  VALUES (:nom, :pourcentage_gain, :espece, :prix , :photos)");

        $result = $stmt->execute([
            ':nom' => $nom,
            ':pourcentage_gain' => $pourcentage_gain,
            ':espece' => $espece,
            ':prix' => $prix,
            ':photos' => $photos
        ]);

        if (!$result) {
            var_dump($stmt->errorInfo());
            return false;
        }

        return true;
    }


    public function modifierAlimentation($id, $nom, $pourcentage_gain, $espece, $prix, $photos)
    {
        $db = Flight::db();

        $stmt = $db->prepare("UPDATE elevage_Alimentation 
                                  SET nom = :nom, pourcentage_gain = :pourcentage_gain, espece = :espece, :prix photos = :photos 
                                  WHERE id = :id");

        $result = $stmt->execute([
            ':id' => $id,
            ':nom' => $nom,
            ':pourcentage_gain' => $pourcentage_gain,
            ':espece' => $espece,
            ':prix' => $prix,
            ':photos' => $photos
        ]);

        if (!$result) {
            var_dump($stmt->errorInfo());
            return false;
        }

        return true;
    }

    public function supprimerAlimentation($id)
    {
        $db = Flight::db();
        $stmt = $db->prepare("DELETE FROM elevage_Alimentation WHERE id = :id");
        $result = $stmt->execute([':id' => $id]);

        if (!$result) {
            var_dump($stmt->errorInfo());
            return false;
        }

        return true;
    }

    public function getAlimentationById($idAlimentation)
    {
        $db = Flight::db(); // Récupération de l'instance de la base de données
        $sql = "SELECT * FROM elevage_Alimentation WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$idAlimentation]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne l'animal sous forme de tableau associatif
    }

}